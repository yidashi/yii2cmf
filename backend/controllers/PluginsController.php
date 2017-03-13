<?php

namespace backend\controllers;

use backend\models\ModuleConfig;
use backend\models\PluginsConfig;
use common\models\Module;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

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
        $plugins = Yii::$app->pluginManager->findAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $plugins
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    // 安装
    public function actionInstall()
    {
        $id = Yii::$app->request->post('id');
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->findOne($id);
        if(!$pluginManager->install($plugin)){
            Yii::$app->session->setFlash('error', '插件安装失败');
        } else {
            Yii::$app->session->setFlash('success', '插件安装成功');
        }
        return $this->redirect(['index']);
    }
    //卸载
    public function actionUninstall()
    {
        $id = Yii::$app->request->post('id');
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->findOne($id);
        if(!$pluginManager->uninstall($plugin)){
            Yii::$app->session->setFlash('error', '插件卸载失败');
        } else {
            Yii::$app->session->setFlash('success', '插件卸载成功');
        }
        return $this->redirect(['index']);
    }
    // 开启
    public function actionOpen()
    {
        $id = Yii::$app->request->post('id');
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->findOne($id);
        if(!$plugin->install){
            Yii::$app->session->setFlash('error', '插件没安装');
        }
        if(!$pluginManager->open($plugin)){
            Yii::$app->session->setFlash('error', '插件打开失败');
        } else {
            Yii::$app->session->setFlash('success', '插件打开成功');
        }
        return $this->redirect(['index']);
    }
    // 关闭
    public function actionClose()
    {
        $id = Yii::$app->request->post('id');
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->findOne($id);
        if(!$plugin->install){
            Yii::$app->session->setFlash('error', '插件没安装');
        }
        if(!$pluginManager->close($plugin)){
            Yii::$app->session->setFlash('error', '插件关闭失败');
        } else {
            Yii::$app->session->setFlash('success', '插件关闭成功');
        }
        return $this->redirect(['index']);
    }

    /**
     * 插件配置
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionConfig($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->findOne($id);
        if(!$plugin->install){
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $configs = Json::decode($plugin->getModel()->config);
        $configModels = [];
        if (!empty($configs)) {
            foreach ($configs as $k => $config) {
                $configModel = new ModuleConfig();
                $configModel->scenario = 'init';
                $configModel->attributes = $config;
                $configModels[$k] = $configModel;
            }
        }
        $model = $plugin->getModel();
        if (\Yii::$app->request->isPost && Model::loadMultiple($configModels, \Yii::$app->request->post()) && Model::validateMultiple($configModels)) {
            $configs = Json::encode($configModels);
            $model->config = $configs;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('config', [
            'model' => $model,
            'configModels' => $configModels
        ]);
    }
}
