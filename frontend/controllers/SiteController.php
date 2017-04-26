<?php

namespace frontend\controllers;

use common\models\Category;
use frontend\models\Article;
use frontend\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['sitemap'],
                'duration' => 60 * 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->published(),
            'sort' => [
                'defaultOrder' => [
                    'is_top' => SORT_DESC,
                    'published_at' => SORT_DESC
                ]
            ]
        ]);
        $categories = Category::find()->all();
        $hotTags = Tag::hot();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'hotTags' => $hotTags
        ]);
    }

    /**
     * 网站地图，百度搜索引擎爬虫用.
     *
     * @return array
     */
    public function actionSitemap()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        \Yii::$container->set('yii\web\XmlResponseFormatter', ['rootTag' => 'urlset', 'itemTag' => 'url']);
        $urls = [];
        $models = Article::find()->published()->select('id')->orderBy(['id' => SORT_DESC])->each(20);
        foreach ($models as $model) {
            $url = [];
            $url['loc'] = Url::to(['/article/view', 'id' => $model->id], true);
            $urls[] = $url;
        }

        return $urls;
    }
}
