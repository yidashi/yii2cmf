<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\behaviors;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;

/**
 * ContextModelControlBehavior allows usage of the filtering context.
 * For example: items per specific category, comments by particular user etc.
 * This controller finds and creates models including possible filtering context.
 *
 * @property ActiveRecordInterface[]|Model[] $contextModels active context models.
 * @property array $context default context config.
 * @property array $contextModel default active context model.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class ContextModelControlBehavior extends ModelControlBehavior
{
    /**
     * @var array specifies possible contexts.
     * The array key is considered as context name, value - as context config.
     * Config should contain following keys:
     *
     * - class: string, class name of context model.
     * - attribute: string, name of model attribute, which refers to the context model primary key.
     * - url: array|string, URL config or route to the controller, which manage context models.
     * - required: boolean, whether this context is mandatory for this controller or optional.
     *
     * For example:
     *
     * ```php
     * [
     *     'user' => [
     *         'class' => 'User',
     *         'attribute' => 'userId',
     *         'url' => 'user/view',
     *     ]
     * ]
     * ```
     */
    public $contexts;

    /**
     * @var ActiveRecordInterface[]|Model[] stores the active context models, which means the ones, which passed
     * through the query params.
     */
    private $_contextModels;


    /**
     * Return context info by given name.
     * If 'null' name provided the first declared context will be returned.
     * @param string|null $name context name.
     * @return array context config.
     */
    public function getContext($name = null)
    {
        if ($name === null) {
            reset($this->contexts);
            return current($this->contexts);
        }
        if (!isset($this->contexts[$name])) {
            throw new InvalidParamException("Undefined context '{$name}'");
        }
        return $this->contexts[$name];
    }

    /**
     * @return ActiveRecordInterface[]|Model[] active context models
     */
    public function getContextModels()
    {
        if (!is_array($this->_contextModels)) {
            $this->_contextModels = $this->findContextModels();
        }
        return $this->_contextModels;
    }

    /**
     * @param ActiveRecordInterface[]|Model[] $contextModels active context models
     */
    public function setContextModels($contextModels)
    {
        $this->_contextModels = $contextModels;
    }

    /**
     * Return active context model by given name.
     * If 'null' name provided the first active context model will be returned.
     * @param string|null $name context name.
     * @return ActiveRecordInterface|Model default active context model.
     */
    public function getContextModel($name = null)
    {
        $contextModels = $this->getContextModels();
        if ($name === null) {
            if (empty($contextModels)) {
                throw new InvalidParamException("There is no context model.");
            }
            reset($contextModels);
            return current($contextModels);
        }
        if (!isset($contextModels[$name])) {
            throw new InvalidParamException("Undefined context '{$name}'");
        }
        return $contextModels[$name];
    }

    /**
     * Finds all active context models.
     * @return ActiveRecordInterface[]|Model[] active contexts.
     * @throws InvalidConfigException on invalid configuration.
     * @throws NotFoundHttpException on missing required context.
     */
    protected function findContextModels()
    {
        $contextModels = [];
        if (is_array($this->contexts)) {
            $queryParams = Yii::$app->request->getQueryParams();
            foreach ($this->contexts as $name => $config) {
                if (empty($config['attribute'])) {
                    throw new InvalidConfigException('Context "attribute" parameter must be set.');
                }
                $attribute = $config['attribute'];
                if (array_key_exists($attribute, $queryParams)) {
                    $contextModels[$name] = $this->findContextModel($config, $queryParams[$attribute]);
                } elseif (isset($config['required']) && $config['required']) {
                    throw new NotFoundHttpException(Yii::t('yii2tech-admin', "Context '{name}' required.", ['name' => $name]));
                }
            }
        }
        return $contextModels;
    }

    /**
     * Initializes a particular active context.
     * @param array $config context configuration.
     * @param mixed $id context model primary key value.
     * @return ActiveRecordInterface|Model context model instance.
     * @throws InvalidConfigException on invalid configuration.
     * @throws NotFoundHttpException if context model not found.
     */
    protected function findContextModel($config, $id)
    {
        if (empty($config['class'])) {
            throw new InvalidConfigException('Context "class" parameter must be set.');
        }

        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $config['class'];
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii2tech-admin', "Context object not found: {id}", ['id' => $id]));
        }
    }

    /**
     * Checks if named context is active (present in the query params).
     * If 'null' name provided, checks if at least one context is active.
     * @param string|null $name context name.
     * @return boolean whether context is active.
     */
    public function isContextActive($name = null)
    {
        $contextModels = $this->getContextModels();
        if ($name === null) {
            return (!empty($contextModels));
        }
        return isset($contextModels[$name]);
    }

    // URL :

    /**
     * Returns query params for currently active contexts, like `['groupId' => 12]`.
     * This method can be used to compose links.
     * @return array query params.
     */
    public function getContextQueryParams()
    {
        $queryParams = [];
        foreach ($this->getContextModels() as $name => $model) {
            $queryParams[$this->contexts[$name]['attribute']] = $model->getPrimaryKey();
        }
        return $queryParams;
    }

    /**
     * Composes URL, which leads to the context model index page.
     * @param string|null $name context name.
     * @return array URL config.
     */
    public function getContextUrl($name = null)
    {
        $config = $this->getContext($name);

        if (isset($config['indexUrl'])) {
            $url = (array)$config['indexUrl'];
        } else {
            if (isset($config['controller'])) {
                $controllerId = $config['controller'];
            } else {
                if ($name !== null) {
                    $controllerId = $name;
                } else {
                    $controllerId = trim(substr($config['attribute'], 0, -2), '_');
                }
            }
            $url = ["/{$controllerId}/index"];
        }

        return $url;
    }

    /**
     * Composes URL, which leads to the context model details page.
     * @param string|null $name context name.
     * @return array URL config.
     */
    public function getContextModelUrl($name = null)
    {
        $model = $this->getContextModel($name);
        $config = $this->getContext($name);

        if (isset($config['viewUrl'])) {
            $url = (array)$config['viewUrl'];
        } else {
            if (isset($config['controller'])) {
                $controllerId = $config['controller'];
            } else {
                if ($name !== null) {
                    $controllerId = $name;
                } else {
                    $controllerId = Inflector::camel2id(StringHelper::basename($model->className()));
                }
            }
            $url = ["/{$controllerId}/view"];
        }

        $url['id'] = $model->getPrimaryKey();
        return $url;
    }

    // Override :

    /**
     * @inheritdoc
     */
    public function findModel($id)
    {
        $model = parent::findModel($id);
        foreach ($this->getContextModels() as $name => $contextModel) {
            $attribute = $this->contexts[$name]['attribute'];
            if ($model->$attribute != $contextModel->getPrimaryKey()) {
                throw new NotFoundHttpException(Yii::t('yii2tech-admin', "Object not found: {id}", ['id' => $contextModel->getPrimaryKey()]));
            }
        }
        return $model;
    }

    /**
     * @inheritdoc
     */
    public function newModel()
    {
        $model = parent::newModel();
        foreach ($this->getContextModels() as $name => $contextModel) {
            $attribute = $this->contexts[$name]['attribute'];
            $model->$attribute = $contextModel->getPrimaryKey();
        }
        return $model;
    }

    /**
     * @inheritdoc
     */
    public function newSearchModel()
    {
        $model = parent::newSearchModel();
        foreach ($this->getContextModels() as $name => $contextModel) {
            $attribute = $this->contexts[$name]['attribute'];
            $model->$attribute = $contextModel->getPrimaryKey();
        }
        return $model;
    }
}