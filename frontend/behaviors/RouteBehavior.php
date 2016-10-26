<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/5
 * Time: 下午3:57
 */

namespace frontend\behaviors;


use Yii;
use yii\base\Behavior;
use yii\caching\DbDependency;
use yii\web\Application;

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
            $list = \common\models\Category::find()->select('id,slug')->asArray()->all();
            Yii::$app->cache->set('cateRouteCache', $list, 60*60*24, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM {{%category}}']));
        }
        if(!empty($list)) {
            $rules = [];
            $cate = [];
            foreach ($list as $item) {
                $cate[] = $item['slug'];
            }
            $cate = implode('|', $cate);
            $rules['<cate:('.$cate.')>'] = 'article/index';
            Yii::$app->getUrlManager()->addRules($rules, false);
        }

        // 单页路由
        $list = Yii::$app->cache->get('pageRouteCache');
        if ($list === false) {
            $list = \common\models\Page::find()->select('id,slug')->asArray()->all();
            Yii::$app->cache->set('pageRouteCache', $list, 60*60*24, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM {{%page}}']));
        }
        if(!empty($list)) {
            $rules = [];
            $page = [];
            foreach ($list as $item) {
                $page[] = $item['slug'];
            }
            $page = implode('|', $page);
            $rules[] = [
                'pattern' => '<slug:('.$page.')>',
                'route' => 'page/slug',
                'suffix' => '.html'
            ];
            Yii::$app->getUrlManager()->addRules($rules, false);
        }
    }
}