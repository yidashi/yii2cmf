<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2018/10/20
 * Time: 00:05
 */

namespace frontend\components;


use common\models\Category;
use common\models\DocumentModule;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class DocumentUrlRule extends Object implements UrlRuleInterface
{
    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            $params = [];
            if (isset($matches[1])) {
                if (!ArrayHelper::keyExists($matches[1], DocumentModule::getTypeEnum())) {
                    return false;
                }
                $params['module'] = $matches[1];

            }
            if (isset($matches[3])) {
                if (!Category::find()->where(['slug' => $matches[3]])->exists()) {
                    return false;
                }
                $params['cate'] = $matches[3];
            }
            return ['document/index', $params];
            // 检查 $matches[1] 和 $matches[3]
            // 确认是否匹配到一个数据库中保存的模型和分类。
            // 如果匹配，设置参数 $params['module'] 和 / 或 $params['cate']
            // 返回 ['document/index', $params]
        }
        return false; // 本规则不会起作用
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|bool the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'document/index') {
            $url = '';
            if (isset($params['module'], $params['cate'])) {
                $url = $params['module'] . '/' . $params['cate'];
            } elseif (isset($params['module'])) {
                $url = $params['module'];
            } elseif (isset($params['cate'])) {
                $category = Category::findOne(['slug' => $params['cate']]);
                $url = $category->module . '/' . $params['cate'];
            }
            return $url . (isset($params['page']) && $params['page'] > 1 ? '?page=' . $params['page'] : '');
        }
        return false; // this rule does not apply
    }
}