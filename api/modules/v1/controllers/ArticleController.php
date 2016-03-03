<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16-1-28
 * Time: 下午6:40
 */

namespace api\modules\v1\controllers;


use api\modules\v1\models\Article;
use yii\data\ActiveDataProvider;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $topStories = Article::find()->orderBy(['view' => SORT_DESC])->limit(5)->asArray()->all();
        $stories = Article::find()->orderBy(['created_at' => SORT_DESC, 'title' => SORT_ASC])->limit(10)->asArray()->all();
        return [
            'date' => date('Ymd'),
            'stories' => $stories,
            'top_stories' => $topStories
        ];
    }

    public function actionList()
    {
        $query = Article::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ],
        ]);
        return [
            'date' => date('Ymd'),
            'stories' => $provider->getModels(),
        ];
    }
    public function actionView($id = 0)
    {
        $article = Article::find()->where(['id' => $id])->with('data')->asArray()->one();
        return $article;
    }
}