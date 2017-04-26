<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/2/25
 * Time: 下午2:36
 */

namespace api\modules\v1\models;


use yii\helpers\ArrayHelper;

class Article extends \common\models\Article
{
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'cover' => function ($model) {
                return ArrayHelper::getValue($model, 'cover.url', '');
            }
        ]);
    }

    public function extraFields()
    {
        return [
            'data'
        ];
    }
}