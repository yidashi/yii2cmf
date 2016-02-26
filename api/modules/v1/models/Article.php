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

    public function extraFields()
    {
        return ['data'];
    }
}