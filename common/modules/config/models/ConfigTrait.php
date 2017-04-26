<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/11/7
 * Time: 下午11:09
 */

namespace common\modules\config\models;


trait ConfigTrait
{
    public function getConfig()
    {
        return \Yii::$app->get('config');
    }
}