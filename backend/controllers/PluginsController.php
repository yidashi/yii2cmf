<?php

namespace backend\controllers;

use Yii;
use common\models\Module;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
}
