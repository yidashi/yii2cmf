<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 11:31
 */

namespace frontend\controllers;


use yii\db\Query;
use yii\web\Controller;

class TestController extends Controller{
    public function actionIndex()
    {
        $result = (new Query())->from('{{%order}}')->where(['partner_oid'=>'2614311','partner_id'=>1])->select('partner_oid')->createCommand()->queryScalar();
        print_r($result);
        die;
    }
} 