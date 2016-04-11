<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/5
 * Time: 下午3:57
 */

namespace frontend\components;


use yii\base\Behavior;
use yii\caching\DbDependency;
use yii\caching\TagDependency;
use yii\web\Application;
use Yii;

class RouteBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    public function beforeRequest($event)
    {
        $db = \Yii::$app->db;
        // 分类路由
        $list = Yii::$app->cache->get('cateRouteCache');
        if ($list === false) {
            $list = \common\models\Category::find()->select('id,name')->asArray()->all();
            Yii::$app->cache->set('cateRouteCache', $list, 60*60*24, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM {{%category}}']));
        }
        $rules = [];
        $cate = [];
        foreach ($list as $item) {
            $cate[] = $item['name'];
        }
        $cate = implode('|', $cate);
        $rules['<cate:('.$cate.')>'] = 'article/index';
        Yii::$app->UrlManager->addRules($rules);
        // 单页路由
        $list = Yii::$app->cache->get('pageRouteCache');
        if ($list === false) {
            $list = \common\models\Page::find()->select('id,name')->asArray()->all();
            Yii::$app->cache->set('pageRouteCache', $list, 60*60*24, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM {{%page}}']));
        }
        $rules = [];
        $page = [];
        foreach ($list as $item) {
            $page[] = $item['name'];
        }
        $page = implode('|', $page);
        $rules[] = [
            'pattern' => '<name:('.$page.')>',
            'route' => 'page/index',
            'suffix' => '.html'
        ];
        Yii::$app->UrlManager->addRules($rules);
    }
}