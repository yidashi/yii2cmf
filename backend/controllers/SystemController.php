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
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SystemController extends Controller
{
    public function actionConfig($group = 'system')
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Config::find()->where(['group' => $group]),
            'pagination' => false
        ]);
        $configs = $dataProvider->getModels();
        if (Model::loadMultiple($configs, \Yii::$app->request->post()) && Model::validateMultiple($configs)) {
            foreach ($configs as $config) {
                /* @var $config Config */
                $config->save(false);
            }
            TagDependency::invalidate(\Yii::$app->cache, 'systemConfig');
            return $this->redirect('config');
        }

        return $this->render('config', [
            'group' => $group,
            'dataProvider' => $dataProvider
        ]);
    }
}
