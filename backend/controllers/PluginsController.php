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
            } else {
                $plugins[$k]['install'] = 1;
            }
            $pluginsClass = Yii::createObject([
                'class' => 'plugins\\' . $dir . '\Plugins'
            ]);
            $plugins[$k]['title'] = $pluginsClass->info['title'];
            $plugins[$k]['name'] = $pluginsClass->info['name'];
            $plugins[$k]['version'] = $pluginsClass->info['version'];
            $plugins[$k]['author'] = $pluginsClass->info['author'];
            $plugins[$k]['status'] = $pluginsClass->info['status'];
        }
        $dataProvider = new ArrayDataProvider([
            'models' => $plugins
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInstall()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (!empty($model)) {
            Yii::$app->session->setFlash('error', '有同名插件已经安装');
            return $this->redirect(['index']);
        }
        $model= new Module();
        $pluginsClass = Yii::createObject([
            'class' => 'plugins\\' . $name . '\Plugins'
        ]);
        $model->attributes = $pluginsClass->info;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionUninstall()
    {
        $name = Yii::$app->request->post('name');
        $model = Module::find()->where(['name' => $name])->one();
        if (empty($model)) {
            Yii::$app->session->setFlash('error', '插件没安装');
            return $this->redirect(['index']);
        }
        $model->delete();
        return $this->redirect(['index']);
    }
}
