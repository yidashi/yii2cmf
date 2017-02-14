<?php

namespace backend\controllers;

use backend\widgets\grid\SwitcherAction;
use common\models\Module;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends Controller
{
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
        $query = Module::find()->where(['type' => Module::TYPE_CORE]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function findModel($id)
    {
        return Module::findOne($id);
    }
}
