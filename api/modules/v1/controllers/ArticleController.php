<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16-1-28
 * Time: 下午6:40
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class ArticleController extends Controller
{
    public function actionList()
    {
        $query = Article::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $dataProvider;
    }
    public function actionView($id = 0)
    {
        $article = Article::find()->where(['id' => $id])->with('data')->asArray()->one();
        $article['data']['content'] = \yii\helpers\Markdown::process($article['data']['content'], 'gfm');
        $css = Url::to('/', true) . \Yii::getAlias('@web') . '/article.css';
        $html = <<<CONTENT
<div class="view-title">
        <h1>{$article['title']}</h1>
    </div>
    <div class="action">
        <span class="user">{$article['author']}</span>
        <span class="views">{$article['view']}次浏览</span>
    </div>
    <div class="view-content">{$article['data']['content']}</div>
CONTENT;
        $article['css'] = $css;
        $article['html'] = $html;
        return $article;
    }
}