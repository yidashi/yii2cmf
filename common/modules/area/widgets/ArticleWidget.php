<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/14
 * Time: 上午10:51
 */

namespace common\modules\area\widgets;


use frontend\models\Article;
use yii\base\Widget;
use yii\helpers\Html;

class ArticleWidget extends Widget
{
    public $model;

    public function run()
    {
        $template = $this->model->template;
        $articles = Article::find()->filterWhere(['category_id' => $template['category']])->orderBy([$template['order'] => SORT_DESC])->limit($template['limit'])->all();
        $items = [];
        foreach ($articles as $article) {
            $items[] = Html::a($article->title, ['/article/view', 'id' => $article->id]);
        }
        return Html::ul($items, ['class' => 'post-list', 'encode' => false]);
    }
}