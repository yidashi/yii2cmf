<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 下午8:37
 */

namespace common\models;


use yii\base\Model;

class ArticleForm extends Model
{
    public $title;
    public $category_id;
    public $cover;
    public $tags;
    public $content;

    public function rules()
    {
        return [
            [['title', 'category_id', 'content'], 'required'],
            [['content', 'cover', 'tags'], 'string']
        ];
    }
}