<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/11/22 9:57
 * Description:
 */

namespace common\models;


use yii\base\Model;

class UserLevel extends Model
{
    public static $levels = [
        '1' => [
            'nick' => '菜鸟',
            'min' => 0,
            'max' => 10,
        ],
        '2' => [
            'nick' => '小虾',
            'min' => 10,
            'max' => 50,
        ],
        '3' => [
            'nick' => '大虾',
            'min' => 50,
            'max' => 100,
        ],
        '4' => [
            'nick' => '小牛',
            'min' => 100,
            'max' => 500,
        ],
        '5' => [
            'nick' => '大牛',
            'min' => 500,
            'max' => 1000,
        ],
        '6' => [
            'nick' => '专家',
            'min' => 1000,
            'max' => 2000,
        ],
        '7' => [
            'nick' => '大师',
            'min' => 2000,
            'max' => 5000,
        ],
        '8' => [
            'nick' => '小神',
            'min' => 5000,
            'max' => 10000,
        ],
        '9' => [
            'nick' => '大神',
            'min' => 10000,
            'max' => 99999,
        ],
        '10' => [
            'nick' => '上帝',
            'min' => 99999,
            'max' => 9999999,
        ],
    ];
    public static function getLevel($money)
    {
        foreach (self::$levels as $level) {
            if ($money > $level['min'] && $money < $level['max']) {
                return $level;
            }
        }
    }
}