<?php
/**
 * author: yidashi
 * Date: 2016/1/11
 * Time: 17:59.
 */
namespace config\controllers;

use config\models\Config;
use Yii;
use yii\base\Model;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class CustomController extends Controller
{
    public function actionIndex()
    {
        $groups = Yii::$app->config->get('CONFIG_GROUP');
        $group = Yii::$app->request->get('group', current(array_keys($groups)));
        $dataProvider = new ActiveDataProvider([
            'query' => Config::find()->where(['group' => $group]),
            'pagination' => false
        ]);
        return $this->render('index', [
            'groups' => $groups,
            'group' => $group,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionStore()
    {
        $groups = Yii::$app->config->get('CONFIG_GROUP');
        $group = Yii::$app->request->get('group', current(array_keys($groups)));
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
            TagDependency::invalidate(\Yii::$app->cache,  Yii::$app->config->cacheTag);
            return $this->redirect(['index', 'group' => $group]);
        } else {
            Yii::$app->session->setFlash('error', '保存失败');
            return $this->redirect(['index', 'group' => $group]);
        }
    }
}
