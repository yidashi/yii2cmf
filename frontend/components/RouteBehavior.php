<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/5
 * Time: 下午3:57
 */

namespace frontend\components;


use yii\base\Behavior;
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
        $list = $db->cache(function ($db) {
            return \common\models\Category::find()->select('id,name')->asArray()->all();
        }, 60 * 60 * 24);
        $rules = [];
        $cate = [];
        foreach ($list as $item) {
            $cate[] = $item['name'];
        }
        $cate = implode('|', $cate);
        $rules['<cate:('.$cate.')>'] = 'article/index';
        Yii::$app->UrlManager->addRules($rules);
        // 单页路由
        $list = $db->cache(function ($db) {
            return \common\models\Page::find()->select('id,name')->asArray()->all();
        }, 60 * 60 * 24);
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