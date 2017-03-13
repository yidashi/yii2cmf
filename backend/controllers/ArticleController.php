<?php

namespace backend\controllers;

use backend\models\search\Article as ArticleSearch;
use common\models\Article;
use common\models\ArticleData;
use common\models\ArticleModule;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
            'ajax-update-field' => [
                'class' => 'common\\actions\\AjaxUpdateFieldAction',
                'allowFields' => ['status', 'is_top', 'is_hot', 'is_best'],
                'findModel' => [$this, 'findModel']
            ],
            'switcher' => [
                'class' => 'backend\widgets\grid\SwitcherAction'
            ]
        ];
    }

    /**
     * Lists all Article models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember('', $this->id);
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 回收站列表
     *
     * @return mixed
     */
    public function actionTrash()
    {
        $query = \common\models\Article::find()->onlyTrashed();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('trash',[
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 还原
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionReduction()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = Article::find()->where(['id' => $id])->onlyTrashed()->one();
        if(!$model) {
            throw new NotFoundHttpException('文章不存在!');
        }
        $model->restore();
        return [
            'message' => '操作成功'
        ];
    }

    /**
     * 彻底删除
     * @return array
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionHardDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = Article::find()->where(['id' => $id])->onlyTrashed()->one();
        if(!$model) {
            throw new NotFoundHttpException('文章不存在!');
        }
        $model->delete();
        return [
            'message' => '操作成功'
        ];
    }
    public function actionClear()
    {
        if (Article::deleteAll(['>', 'deleted_at', 0]) !== false) {
            Yii::$app->session->setFlash('success', '操作成功');
            return $this->redirect('trash');
        }
        throw new Exception('操作失败');
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
     * @param string $module 文章类型
     * @return mixed
     */
    public function actionCreate($module = 'base')
    {
        $model = new Article();
        $model->status = Article::STATUS_ACTIVE;
        $model->module = $module;
        $moduleModelClass = $model->findModuleClass($module);
        $moduleModel = new $moduleModelClass;
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->load(Yii::$app->request->post());
                $model->save();
                if($model->hasErrors()) {
                    throw new Exception('操作失败');
                }
                $moduleModel->load(Yii::$app->request->post());
                $moduleModel->id = $model->id;
                $moduleModel->save();
                if($moduleModel->hasErrors()) {
                    throw new Exception('操作失败');
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', '发布成功');
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['index']);
        }

        $articleModules = ArticleModule::find()->all();
        $articleModuleItems = [];
        foreach($articleModules as $articleModule) {
            $articleModuleItem = [];
            $articleModuleItem['label'] = $articleModule->title;
            $articleModuleItem['url'] = ['/article/create', 'module' => $articleModule->name];
            $articleModuleItem['active'] = $module == $articleModule->name;
            $articleModuleItems[] = $articleModuleItem;
        }
        return $this->render('create', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'module' => $module,
            'articleModuleItems' => $articleModuleItems
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
        $model = Article::find()->where(['id' => $id])->with('data')->one();
        $moduleModel = $model->data;
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->load(Yii::$app->request->post());
                $model->save();
                if($model->hasErrors()) {
                    throw new Exception('操作失败');
                }
                if ($moduleModel) {
                    $moduleModel->load(Yii::$app->request->post());
                    $moduleModel->save();
                    if($moduleModel->hasErrors()) {
                        throw new Exception('操作失败');
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', '操作成功');
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'module' => $model->module
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
        $this->findModel($id)->softDelete();

        return $this->redirect(Url::previous($this->id));
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
    public function findModel($id)
    {
        if (($model = Article::find()->where(['id' => $id])->notTrashed()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
