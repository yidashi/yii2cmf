<?php
/**
 * author: yidashi
 * Date: 2016/1/11
 * Time: 17:59.
 */
namespace backend\controllers;

use common\models\Config;
use yidashi\webuploader\WebuploaderAction;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SystemController extends Controller
{
    public function actionConfig()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Config::find(),
            'pagination' => false
        ]);
        $configs = $dataProvider->getModels();
        if (Model::loadMultiple($configs, \Yii::$app->request->post()) && Model::validateMultiple($configs)) {
            foreach ($configs as $config) {
                $config->save(false);
            }

            return $this->redirect('config');
        }

        return $this->render('config', ['dataProvider' => $dataProvider]);
    }
}
