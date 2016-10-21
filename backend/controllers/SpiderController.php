<?php

namespace backend\controllers;

use common\models\Article;
use common\models\ArticleData;
use common\models\Category;
use common\models\Gather;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Yii;
use common\models\Spider;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpiderController implements the CRUD actions for Spider model.
 */
class SpiderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Spider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Spider::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Spider model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Spider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Spider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Spider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Spider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Spider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Spider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Spider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCraw($id)
    {
        set_time_limit(0);
        Yii::$app->response->format = 'json';
        $transaction = Yii::$app->db->beginTransaction();
        $spider = $this->findModel($id);
        $client = new Client();
        $crawler = $client->request('get', $spider->target_category_url);
        $category = Category::findOne(['title' => $spider->target_category]);
        if ($category == null) {
            $category = new Category();
            $category->slug = $spider->target_category;
            $category->title = $spider->target_category;
            $category->save();
        }
        $crawler->filter($spider->list_dom)->each(function (Crawler $node) use ($spider, $client, $category) {
            try {
                $contentUrl = $node->attr('href');
                $gather = Gather::findOne(['url_org' => md5($contentUrl)]);
                if ($gather !== null) {
                    return;
                }
                $contentCrawler = $client->request('get', $contentUrl);
                $title = $contentCrawler->filter($spider->title_dom)->text();
                $content = $contentCrawler->filter($spider->content_dom)->html();
                $content = preg_replace_callback('/<img[\s\S]*?src="([\s\S]*?)"[\s\S]*?>/', function ($matches) {
                    if (!empty($matches[1])) {
                        $imgDir = Yii::$app->storage->basePath . '/' . date('Ymd');
                        if (!is_dir($imgDir)) {
                            FileHelper::createDirectory($imgDir);
                        }
                        $imgPath = $imgDir . '/' . time() . mt_rand(1000, 9999) . '.jpg';
                        file_put_contents($imgPath, file_get_contents($matches[1]));
                        return Html::img(Yii::$app->storage->path2url($imgPath));
                    }
                }, $content);
                $article = new Article();
                $article->title = $title;
                $article->status = Article::STATUS_ACTIVE;
                $article->category_id = $category->id;
                $article->source = $spider->domain;
                $article->save();
                $articleData = new ArticleData();
                $articleData->content = $content;
                $articleData->markdown = 0;
                $article->link('data', $articleData);
                $gather = new Gather();
                $gather->url_org = md5($contentUrl);
                $gather->save(false);
            } catch (\Exception $e) {

            }
        });
        $transaction->commit();
        return ['message' => '采集成功'];
    }
}