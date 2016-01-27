<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 14:42.
 */
namespace frontend\models;

class Nav extends \common\models\Nav
{
    public function lists()
    {
        $list = \Yii::$app->cache->get('navList');
        if ($list === false) {
            $list = static::find()->all();
            \Yii::$app->cache->set('navList', $list, 60 * 60 * 24);
        }

        return $list;
    }
}
