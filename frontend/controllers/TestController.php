<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 11:31.
 */
namespace frontend\controllers;

use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\web\Controller;

class TestController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $arr = [35, 20, 55, 79, 63, 15, 19, 88];
        print_r($this->bubbleSort($arr));
        die;
    }

    public function quickSort($arr)
    {
        $len = count($arr);
        if ($len <= 0) {
            return $arr;
        }
        $base = $arr[0];
        $left = [];
        $right = [];
        for ($i = 1;$i < $len;++$i) {
            if ($arr[$i] > $base) {
                array_push($right, $arr[$i]);
            } elseif ($arr[$i] < $base) {
                array_push($left, $arr[$i]);
            }
        }

        return array_merge($this->quickSort($left), [$base], $this->quickSort($right));
    }
    public function bubbleSort($arr)
    {
        $len = count($arr);
        if ($len <= 0) {
            return $arr;
        }
        for ($i = 1;$i < $len;++$i) {
            for ($j = 0;$j < $len - $i;++$j) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $tmp;
                }
            }
        }

        return $arr;
    }

    public function actionTest()
    {
        echo '<h1>最简单的csrf攻击</h1>';
        echo Html::img('http://www.thinkphp.cn/Member/logout.html');
        die;
    }

    public function actionValidate($name, $email)
    {
        $model = new DynamicModel(compact('name', 'email'));
        $model->addRule('email', 'email');
        $model->validate();
        if ($model->hasErrors()) {
            // validation fails
            print_r($model->errors);
        } else {
            // validation succeeds
        }
    }
    public function actionFormat()
    {
        echo \Yii::$app->formatter->format('2016-01-24 6:28:00', 'relativeTime');
    }
}
