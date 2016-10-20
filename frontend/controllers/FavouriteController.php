<?php

namespace frontend\controllers;

use common\models\Favourite;
use frontend\models\Article;
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
        $articleId = \Yii::$app->request->post('id', 0);
        if (empty($articleId)) {
            throw new InvalidParamException('参数不合法');
        }
        $article = Article::find()->where(['id' => $articleId])->normal()->one();
        $favourite = Favourite::find()->where(['user_id' => \Yii::$app->user->id, 'article_id' => $articleId])->one();
        if (empty($article)) {
            if (!empty($favourite)) {
                $favourite->delete();
            }
            throw new NotFoundHttpException('文章不存在');
        }
        if (empty($favourite)) {
            $favourite = new Favourite();
            $favourite->user_id = \Yii::$app->user->id;
            $favourite->article_id = $articleId;
            $favourite->save();
            $article->updateCounters(['favourite' => 1]);
            return [
                'action' => 'create',
                'count' => $article->favourite,
            ];
        } else {
            $favourite->delete();
            $article->updateCounters(['favourite' => -1]);
            return [
                'action' => 'cancel',
                'count' => $article->favourite,
            ];
        }
    }

}
