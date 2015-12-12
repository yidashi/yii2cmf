<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54
 */

namespace frontend\controllers;


use common\models\Comment;
use frontend\models\Article;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
class ArticleController extends Controller{
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
                        'actions' => ['create'],
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
                    "imageUrlPrefix"  => \Yii::getAlias('@web') . '/',//图片访问路径前缀
                    "imagePathFormat" => "upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
    public function actionIndex($cid=0)
    {
        $category = Category::find()->where(['id'=>$cid])->select('title')->scalar();
        $query = Article::find()->where(['status'=>Article::STATUS_ACTIVE])->andFilterWhere(['category_id'=>$cid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category
        ]);
    }
    public function actionView($id)
    {
        $model = Article::find()->where(['id'=>$id,'status'=>Article::STATUS_ACTIVE])->one();
        if($model === null){
            throw new NotFoundHttpException('not found');
        }
        $commentModel = new Comment();
        $commentQuery = Comment::find()->where(['article_id'=>$id]);
        $countCommentQuery = clone $commentQuery;
        $pages = new Pagination(['totalCount' => $countCommentQuery->count()]);
        $commentModels = $commentQuery->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();
        $hots = Article::find()->where(['category_id'=>$model->category_id])->limit(10)->orderBy('comment desc')->all();
        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'commentModels' => $commentModels,
            'pages' => $pages,
            'hots' => $hots
        ]);
    }
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '投稿成功，请等待管理员审核！');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
} 