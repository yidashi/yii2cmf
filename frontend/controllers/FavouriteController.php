<?php

namespace frontend\controllers;

use common\modules\document\models\Document;
use common\models\Favourite;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class FavouriteController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = 'json';
        $documentId = \Yii::$app->request->post('id', 0);
        if (empty($documentId)) {
            throw new InvalidParamException('参数不合法');
        }
        $document = Document::find()->where(['id' => $documentId])->normal()->one();
        $favourite = Favourite::find()->where(['user_id' => \Yii::$app->user->id, 'document_id' => $documentId])->one();
        if (empty($document)) {
            if (!empty($favourite)) {
                $favourite->delete();
            }
            throw new NotFoundHttpException('文章不存在');
        }
        if (empty($favourite)) {
            $favourite = new Favourite();
            $favourite->user_id = \Yii::$app->user->id;
            $favourite->document_id = $documentId;
            $favourite->save();
            $document->updateCounters(['favourite' => 1]);
            return [
                'action' => 'create',
                'count' => $document->favourite,
            ];
        } else {
            $favourite->delete();
            $document->updateCounters(['favourite' => -1]);
            return [
                'action' => 'cancel',
                'count' => $document->favourite,
            ];
        }
    }

}
