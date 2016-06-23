<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/25
 * Time: 下午8:50.
 */
namespace frontend\controllers;

use common\models\ArticleData;
use common\models\Favourite;
use common\models\Profile;
use common\models\Vote;
use frontend\models\Article;
use frontend\models\ArticleForm;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class MyController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    'imageUrlPrefix' => \Yii::getAlias('@static').'/', //图片访问路径前缀
                    'imagePathFormat' => 'upload/image/{yyyy}{mm}{dd}/{time}{rand:6}', //上传保存路径
                ],
            ],
        ];
    }
    public function actionArticleList()
    {
        $userId = \Yii::$app->user->id;
        $query = Article::find()->where(['user_id' => $userId])->notTrashed();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        $pages = $dataProvider->getPagination();
        $models = $dataProvider->getModels();
        return $this->render('article-list', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionCreateArticle()
    {
        $model = new ArticleForm();
        if ($model->load(\Yii::$app->request->post()) && $model->store()) {
            \Yii::$app->session->setFlash('success', '投稿成功，请等待管理员审核！');
            return $this->redirect(['create-article']);
        }

        return $this->render('create-article', [
            'model' => $model
        ]);
    }
    public function actionUpdateArticle($id)
    {
        $userId = \Yii::$app->user->id;
        $model = ArticleForm::findOne($id);
        if ($model->load(\Yii::$app->request->post()) && $model->update()) {
            \Yii::$app->session->setFlash('success', '修改成功，请等待管理员审核！');
            return $this->redirect(['update-article', 'id' => $id]);
        }

        return $this->render('update-article', [
            'model' => $model,
        ]);
    }

    public function actionUp()
    {
        $userId = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Vote::find()->where(['type' => 'article', 'user_id' => $userId, 'action' => 'up']),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('up', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionFavourite()
    {
        $userId = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Favourite::find()->where(['user_id' => $userId]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('favourite', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionProfile()
    {
        $userId = \Yii::$app->user->id;
        $profile = Profile::find()->where(['id' => $userId])->one();
        if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile', [
                'model' => $profile
            ]);
        }
    }
}
