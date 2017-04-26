<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/8 17:16
 * Description:
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\Notify;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;

class NotifyController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => QueryParamAuth::className(),
                'tokenParam' => 'access_token',
            ]
        ]);
    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Notify::find()->where(['to_uid' => \Yii::$app->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }
}