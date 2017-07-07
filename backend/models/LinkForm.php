<?php

namespace backend\models;

use yii\base\Model;


class LinkForm extends Model
{
    public $url = "";

    public $name ="";

    public function rules()
    {
        return [
            [['url', 'name'], 'required'],
            [['url', 'name'], 'string'],

        ];
    }


    public function attributeLabels()
    {
        return [];
    }


}
