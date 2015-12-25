<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/25
 * Time: 下午8:50
 */

namespace frontend\controllers;


use common\models\Article;
use yii\data\Pagination;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class MyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create-article'],
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
                    "imageUrlPrefix"  => \Yii::getAlias('@static') . '/',//图片访问路径前缀
                    "imagePathFormat" => "upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ],
            'webupload' => 'yidashi\webuploader\WebuploaderAction'
        ];
    }
    public function actionArticleList()
    {
        $userId = \Yii::$app->user->id;
        $query = Article::find()->where(['user_id' => $userId]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('id desc')
            ->limit($pages->limit)
            ->all();
        return $this->render('article-list', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionCreateArticle()
    {
        $model = new Article();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '投稿成功，请等待管理员审核！');
            return $this->redirect(['create']);
        } else {
            return $this->render('create-article', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdateArticle($id)
    {
        $userId = \Yii::$app->user->id;
        $model = Article::find()->where(['id'=>$id, 'user_id' => $userId])->one();
        if(empty($model)) {
            throw new NotFoundHttpException('文章不存在!');
        }
        return $this->render('update-article', [
           'model' => $model
        ]);
    }
}