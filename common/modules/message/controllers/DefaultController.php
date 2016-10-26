<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/7
 * Time: 下午6:12
 */

namespace common\modules\message\controllers;


use common\modules\message\models\Message;
use common\modules\message\models\MessageForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $query = Message::find()->where(['to_uid' => Yii::$app->user->id])->innerJoinWith('data')->orderBy('id desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionView($id)
    {
        $userId = Yii::$app->user->id;
        $model = Message::find()->where(['id' => $id, 'to_uid' => $userId])->one();
        if ($model == null) {
            throw new NotFoundHttpException('消息不存在');
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionCreate($id = null)
    {
        $model = new MessageForm();
        if (!is_null($id)) {
            $toUser = Yii::$app->user->identity->findIdentity($id);
            $model->toUsername = $toUser->username;
            $model->toUid = $id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('success', '发送成功');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
           'model' => $model
        ]);
    }
}