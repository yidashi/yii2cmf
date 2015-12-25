<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 11:31
 */

namespace frontend\controllers;


use common\models\Category;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class TestController extends Controller{
    public function actionIndex()
    {
        $arr = [35,20,55,79,63,15,19,88];
        print_r($this->bubbleSort($arr));
        die;
    }

    public function quickSort($arr)
    {
        $len = count($arr);
        if($len<=0){
            return $arr;
        }
        $base = $arr[0];
        $left = [];
        $right = [];
        for($i=1;$i<$len;$i++){
            if($arr[$i]>$base){
                array_push($right,$arr[$i]);
            }elseif($arr[$i]<$base){
                array_push($left,$arr[$i]);
            }
        }
        return array_merge($this->quickSort($left),[$base],$this->quickSort($right));
    }
    public function bubbleSort($arr)
    {
        $len = count($arr);
        if($len<=0){
            return $arr;
        }
        for($i=1;$i<$len;$i++){
            for($j=0;$j<$len-$i;$j++){
                if($arr[$j]>$arr[$j+1]){
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $tmp;
                }
            }
        }
        return $arr;
    }

    public function actionTest()
    {
        $list = Category::find()->select('id,title')->asArray()->all();
        $list = ArrayHelper::map($list, 'id', 'title');
        print_r($list);
    }
} 