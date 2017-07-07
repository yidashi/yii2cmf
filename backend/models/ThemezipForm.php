<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/19
 * Time: 上午11:33
 */

namespace backend\models;


use yii\base\Model;

class ThemezipForm extends Model
{
    public $themezip;


    public function rules()
    {
        return [
            ["themezip","file","extensions"=>"zip"]
        ];
    }
}