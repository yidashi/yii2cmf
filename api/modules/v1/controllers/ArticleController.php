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
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class ArticleController extends Controller
{
    public function actionIndex($cid = '')
    {
        $version1 = '5.9.10';
        $version2 = '5.10.1';
        $v1 = explode('.', $version1);
        $v2 = explode('.', $version2);
        $res = 0;
        foreach($v1 as $k => $v) {
            if($v != $v2[$k]){
                $res = $v > $v2[$k] ? 'v1>v2' : 'v2>v1';
            }
        }
        echo $res;die;
        $access_token = \Yii::$app->request->post('access_token');
        $app_version = \Yii::$app->request->post('app_version');
        $id = \Yii::$app->request->post('id');
        $model = DynamicModel::validateData(compact('access_token', 'app_version', 'id'), [
            [['access_token', 'app_version', 'id'], 'required'],
            ['id', 'integer'],
            ['name', 'string'],
            ['email', 'email'],
            ['access_token', 'login']
        ]);
        if ($model->hasErrors()){
            $model->getFirstErrors();
            retur;
        }


        $query = Article::find()->published()->andFilterWhere(['category_id' => $cid]);
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
        $article = Article::find()->published()->where(['id' => $id])->with('data')->asArray()->one();
        $article['data']['content'] = \yii\helpers\Markdown::process($article['data']['content'], 'gfm');
        $css = Url::to('/', true) . \Yii::getAlias('@web') . '/article.css';
        $html = <<<CONTENT
    <div class="view-title">
        <h1>{$article['title']}</h1>
    </div>
    <div class="action">
        <span class="views">{$article['view']}次浏览</span>
    </div>
    <div class="view-content">{$article['data']['content']}</div>
CONTENT;
        $article['css'] = $css;
        $article['html'] = $html;
        return $article;
    }
}