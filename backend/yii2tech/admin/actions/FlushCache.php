<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;
use yii\caching\Cache;

/**
 * FlushCache allows you to flush cache.
 *
 * The cache component to be flushed can be explicitly defined via [[cache]] or fetched automatically.
 *
 * Note that the action uses cache components defined in your current web application configuration file.
 * If you wish to flush cache defined at other application, you should duplicate its definition in the configuration file,
 * or setup it explicitly via [[cache]] property.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class FlushCache extends Action
{
    /**
     * @var array|Cache|string|null cache component(s), which should be flushed.
     * If not set action will flush all cache components found in current application.
     * Each cache component can be specified as application component name, instance of [[Cache]] or its configuration.
     * For example:
     *
     * ```php
     * [
     *     'cache',
     *     'frontendCache' => [
     *         'class' => 'yii\caching\DbCache',
     *         'cacheTable' => '{{%frontendCache}}',
     *     ],
     *     'objectCache' => new \yii\caching\DbCache(['cacheTable' => '{{%objectCache}}']),
     * ]
     * ```
     */
    public $cache;
    /**
     * @var string|array|null flash message to be set on success.
     * @see Action::setFlash() for details on how setup flash.
     */
    public $flash;
    /**
     * @var string|array the default return URL in case it was not set previously.
     * This URL will be used only in case automatic determine of return URL failed.
     */
    public $returnUrl;


    /**
     * Flushes associated cache components.
     * @param string|array|null $name name of the cache component(s), which should be flushed.
     * @return mixed response.
     */
    public function run($name = null)
    {
        $filter = (array)$name;

        if (empty($this->cache)) {
            $caches = $this->findCaches($filter);
        } else {
            $caches = (array)$this->cache;

            if (!empty($filter)) {
                foreach ($caches as $key => $value) {
                    if (is_int($key)) {
                        if (!in_array($value, $filter)) {
                            unset($caches[$key]);
                        }
                    } else {
                        if (!in_array($key, $filter)) {
                            unset($caches[$key]);
                        }
                    }
                }
            }
        }

        $this->flushCaches($caches);

        $this->setFlash($this->flash);

        return $this->goBack();
    }

    /**
     * Returns array of caches in the system, keys are cache components names, values are class names.
     * @param array $cachesNames caches to be found
     * @return array
     */
    private function findCaches(array $cachesNames = [])
    {
        $caches = [];
        $components = Yii::$app->getComponents();
        $findAll = ($cachesNames === []);

        foreach ($components as $name => $component) {
            if (!$findAll && !in_array($name, $cachesNames)) {
                continue;
            }

            if ($component instanceof Cache) {
                $caches[] = $name;
            } elseif (is_array($component) && isset($component['class']) && $this->isCacheClass($component['class'])) {
                $caches[] = $name;
            } elseif (is_string($component) && $this->isCacheClass($component)) {
                $caches[] = $name;
            }
        }

        return $caches;
    }

    /**
     * Checks if given class is a Cache class.
     * @param string $className class name.
     * @return boolean
     */
    private function isCacheClass($className)
    {
        return is_subclass_of($className, Cache::className());
    }

    /**
     * Flushes given caches list.
     * @param array $caches caches list
     */
    private function flushCaches(array $caches)
    {
        foreach ($caches as $cache) {
            if (is_scalar($cache)) {
                Yii::$app->get($cache)->flush();
            } elseif ($cache instanceof Cache) {
                $cache->flush();
            } else {
                Yii::createObject($cache)->flush();
            }
        }
    }

    /**
     * Redirects the browser to the last visited page.
     * If such page can not be indicated [[returnUrl]] will be used.
     * @return mixed response.
     */
    private function goBack()
    {
        $referrerUrl = Yii::$app->getRequest()->getReferrer();
        if ($referrerUrl !== null) {
            return $this->controller->redirect($referrerUrl);
        }
        return $this->controller->goBack($this->returnUrl);
    }
}