<?php

namespace backend\controllers;

use backend\models\ModuleConfig;
use backend\widgets\grid\SwitcherAction;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends Controller
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

    public function actions()
    {
        return [
            'switcher' => SwitcherAction::className()
        ];
    }

    /**
     * Lists all Module models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modules = Yii::$app->moduleManager->findAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $modules
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    // 安装
    public function actionInstall()
    {
        $id = Yii::$app->request->post('id');
        $module = Yii::$app->moduleManager->findOne($id);
        if(!Yii::$app->moduleManager->install($module)){
            Yii::$app->session->setFlash('error', '安装失败');
        } else {
            Yii::$app->session->setFlash('success', '安装成功');
        }
        return $this->redirect(['index']);
    }
    //卸载
    public function actionUninstall()
    {
        $id = Yii::$app->request->post('id');
        $module = Yii::$app->moduleManager->findOne($id);
        if(!Yii::$app->moduleManager->uninstall($module)){
            Yii::$app->session->setFlash('error', '卸载失败');
        } else {
            Yii::$app->session->setFlash('success', '卸载成功');
        }
        return $this->redirect(['index']);
    }

    // 开启
    public function actionOpen()
    {
        $id = Yii::$app->request->post('id');
        $module = Yii::$app->moduleManager->findOne($id);
        if(!$module->install){
            Yii::$app->session->setFlash('error', '没安装');
        }
        if(!Yii::$app->moduleManager->open($module)){
            Yii::$app->session->setFlash('error', '打开失败');
        } else {
            Yii::$app->session->setFlash('success', '打开成功');
        }
        return $this->redirect(['index']);
    }
    // 关闭
    public function actionClose()
    {
        $id = Yii::$app->request->post('id');
        $module = Yii::$app->moduleManager->findOne($id);
        if(!$module->install){
            Yii::$app->session->setFlash('error', '没安装');
        }
        if(!Yii::$app->moduleManager->close($module)){
            Yii::$app->session->setFlash('error', '关闭失败');
        } else {
            Yii::$app->session->setFlash('success', '关闭成功');
        }
        return $this->redirect(['index']);
    }

    // 配置
    public function actionConfig($id)
    {
        $module = Yii::$app->moduleManager->findOne($id);
        if(!$module->install){
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $configs = Json::decode($module->getModel()->config);
        $configModels = [];
        if (!empty($configs)) {
            foreach ($configs as $k => $config) {
                $configModel = new ModuleConfig();
                $configModel->scenario = 'init';
                $configModel->attributes = $config;
                $configModels[$k] = $configModel;
            }
        }
        $model = $module->getModel();
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
