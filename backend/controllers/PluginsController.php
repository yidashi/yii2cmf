<?php

namespace backend\controllers;

use backend\models\PluginsConfig;
use Yii;
use common\models\Module;
use yii\base\DynamicModel;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class PluginsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'open' => ['post'],
                    'close' => ['post'],
                    'install' => ['post'],
                    'uninstall' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Module models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pluginsDir = Yii::getAlias('@plugins/');
        $dirs = array_map('basename',glob($pluginsDir.'*', GLOB_ONLYDIR));
        $plugins = [];
        foreach ($dirs as $k => $dir) {
            $model = Module::find()->where(['name' => $dir])->one();
            if (empty($model)) {
                $plugins[$k]['install'] = 0;
                $plugins[$k]['status'] = Module::STATUS_CLOSE;
            } else {
                $plugins[$k]['install'] = $model->status == Module::STATUS_UNINSTALL ? 0 : 1;
                $plugins[$k]['status'] = $model->status;
            }
            $pluginsClass = Yii::createObject([
                'class' => 'plugins\\' . $dir . '\Plugins'
            ]);
            $plugins[$k]['title'] = $pluginsClass->info['title'];
            $plugins[$k]['name'] = $pluginsClass->info['name'];
            $plugins[$k]['version'] = $pluginsClass->info['version'];
            $plugins[$k]['author'] = $pluginsClass->info['author'];
        }
        $dataProvider = new ArrayDataProvider([
            'models' => $plugins
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    // 安装
    public function actionInstall()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (!empty($model) && $model->status != Module::STATUS_UNINSTALL) {
            Yii::$app->session->setFlash('error', '有同名插件已经安装');
            return $this->redirect(['index']);
        }
        $pluginsClass = Yii::createObject([
            'class' => 'plugins\\' . $name . '\Plugins'
        ]);
        $pluginsClass->install();
        return $this->redirect(['index']);
    }
    //卸载
    public function actionUninstall()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (empty($model) || $model->status == Module::STATUS_UNINSTALL) {
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $pluginsClass = Yii::createObject([
            'class' => 'plugins\\' . $name . '\Plugins'
        ]);
        $pluginsClass->uninstall();
        return $this->redirect(['index']);
    }
    // 开启
    public function actionOpen()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (empty($model)) {
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $model->status = Module::STATUS_OPEN;
        $model->save();
        return $this->redirect(['index']);
    }
    // 关闭
    public function actionClose()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (empty($model)) {
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $model->status = Module::STATUS_CLOSE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * 插件配置
     * @param $name
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionConfig($name)
    {
        $model = Module::find()->where(['name' => $name])->one();
        if (empty($model) || $model->status == Module::STATUS_UNINSTALL) {
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $configs = Json::decode($model->config);
        $configModels = [];
        if (!empty($configs)) {
            foreach ($configs as $k => $config) {
                $configModel = new PluginsConfig();
                $configModel->scenario = 'init';
                $configModel->attributes = $config;
                $configModels[$k] = $configModel;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'models' => $configModels,
            'pagination' => false
        ]);
        if (\Yii::$app->request->isPost && Model::loadMultiple($configModels, \Yii::$app->request->post()) && Model::validateMultiple($configModels)) {
            $configs = Json::encode($configModels);
            $model->config = $configs;
            $model->save();
            Yii::$app->cache->delete('pluginConfing-' . $model->name);
            return $this->redirect(['config', 'name' => $name]);
        }

        return $this->render('config', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
}
