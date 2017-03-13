<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 上午11:37
 */

namespace common\modules\user\controllers;


use common\models\ArticleData;
use common\models\Favourite;
use common\models\Vote;
use common\modules\user\models\User;
use frontend\models\Article;
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
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if (empty($user)) {
            throw new NotFoundHttpException('用户不存在!');
        }
        return $this->render('/index', [
            'user' => $user
        ]);
    }

    public function actionArticleList()
    {
        $query = Article::find()->my()->notTrashed();
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
        return $this->render('/article/list', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionCreateArticle($module = 'base')
    {
        $model = new Article(['module' => $module]);
        $moduleClass = $model->findModuleClass();
        $moduleModel = new $moduleClass();
        if ($model->load(\Yii::$app->request->post()) && $moduleModel->load(\Yii::$app->request->post()) && $model->validate() && $moduleModel->validate() && $model->save(false)) {
            $moduleModel->id = $model->id;
            if ($moduleModel->save(false)) {
                \Yii::$app->session->setFlash('success', '发布成功！');
                return $this->redirect(['create-article']);
            }
        }

        return $this->render('/article/create', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }
    public function actionUpdateArticle($id)
    {
        $model = Article::find()->where(['id' => $id])->my()->with('data')->one();
        if ($model == null) {
            throw new NotFoundHttpException('文章不存在或者不属于你');
        }
        $moduleModel = $model->data;
        if (
            $model->load(\Yii::$app->request->post())
            && $model->validate()
            && $moduleModel->load(\Yii::$app->request->post())
            && $moduleModel->validate()
            && $model->save(false)
            && $moduleModel->save(false)
        ) {
            \Yii::$app->session->setFlash('success', '修改成功！');
            return $this->redirect(['update-article', 'id' => $id]);
        }

        return $this->render('/article/update', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }

    public function actionDeleteArticle($id)
    {
        $model = Article::find()->where(['id' => $id])->my()->one();
        if ($model == null) {
            throw new NotFoundHttpException('文章不存在或者不属于你');
        }
        if ($model->softDelete()) {
            \Yii::$app->session->setFlash('success', '删除成功！');
            return $this->redirect(['article-list']);
        }
    }

    public function actionUp()
    {
        $userId = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Vote::find()->where(['entity' => 'common\models\Article', 'user_id' => $userId, 'action' => 'up']),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('/up/index', [
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
        return $this->render('/favourite/index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionNotice()
    {
        Yii::$app->notify->readAll();
        $dataProvider = Yii::$app->notify->getDataProvider();
        return $this->render('/notice/index', [
            'dataProvider' => $dataProvider
        ]);
    }
}