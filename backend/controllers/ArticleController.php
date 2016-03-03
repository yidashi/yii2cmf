<?php

namespace backend\controllers;

use common\models\ArticleData;
use yidashi\webuploader\WebuploaderAction;
use Yii;
use common\logic\Article;
use backend\models\search\Article as ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
            'webupload' => WebuploaderAction::className(),
        ];
    }
    /**
     * Lists all Article models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $dataModel = new ArticleData();
        if ($model->load(Yii::$app->request->post()) && $dataModel->load(Yii::$app->request->post())) {
            $isValid = $model->validate();
            if ($isValid) {
                $model->save(false);
                $dataModel->id = $model->id;
                $isValid = $dataModel->validate();
                if ($isValid) {
                    $dataModel->save(false);

                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'dataModel' => $dataModel,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataModel = ArticleData::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $dataModel->load(Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $dataModel->validate() && $isValid;
            if ($isValid) {
                $model->save(false);
                $dataModel->save(false);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dataModel' => $dataModel,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Article the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
