<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/2/25
 * Time: 下午2:36
 */

namespace api\modules\v1\models;


class Article extends \common\models\Article
{

    public function fields()
    {
        return array_merge(parent::fields(), [
            'html' => function($model) {
                return <<<CONTENT
    <div class="view-title">
        <h1>{$model->title}</h1>
    </div>
    <div class="action">
        <span class="views">{$model->view}次浏览</span>
    </div>
    <div class="view-content">{$model->data->processedContent}</div>
CONTENT;
            },
            'css' => function($model) {
                return \Yii::$app->request->getHostInfo() . \Yii::$app->request->getBaseUrl() . '/article.css';
            }
        ]);
    }

    public function extraFields()
    {
        return ['data'];
    }
}