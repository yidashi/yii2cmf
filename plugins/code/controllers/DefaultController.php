<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 上午11:09
 */

namespace plugins\code\controllers;


use plugins\code\Plugins;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $plugins = new Plugins();
        $config = $plugins->getConfig();
        $query = (new Query())->from('{{%donation}}');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('index', [
            'config' => $config,
            'dataProvider' => $dataProvider
        ]);
    }
}