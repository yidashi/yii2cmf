<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/14
 * Time: 上午10:51
 */

namespace common\modules\area\widgets;


use common\models\Article;
use yii\base\Widget;
use yii\helpers\Html;

class ArticleWidget extends Widget
{
    public $model;

    public function run()
    {
        $html = \Yii::$app->cache->get([__CLASS__, $this->model->block_id]);
        if (!$this->model->cache || $html === false) {
            $template = $this->model->template;
            $articles = Article::find()->published()
                ->andFilterWhere(['module' => $template['module']])
                ->andFilterWhere(['category_id' => $template['category']])
                ->orderBy([$template['order'] => SORT_DESC])
                ->limit($template['limit'])
                ->all();
            $items = [];
            foreach ($articles as $article) {
                $items[] = Html::a($article->title, ['/article/view', 'id' => $article->id]);
            }
            $html = Html::ul($items, ['class' => 'post-list', 'encode' => false]);
            \Yii::$app->cache->set([__CLASS__, $this->model->block_id], $html);
        }
        return $html;
    }
}