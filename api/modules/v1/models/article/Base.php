<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/9 13:27
 * Description:
 */

namespace api\modules\v1\models\article;


class Base extends \common\models\article\Base
{
    public function fields()
    {
        return [
            'content' => function($model) {
                $css = \Yii::$app->request->getHostInfo() . \Yii::$app->request->getBaseUrl() . '/article.css';
                return <<<CONTENT
    <link href="{$css}" rel="stylesheet"/>
    <div class="view-content">{$model->processedContent}</div>
CONTENT;
            }
        ];
    }
}