<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午4:56
 */

namespace frontend\widgets;


use yii\base\Widget;
use Yii;

class RewardWidget extends Widget
{
    public $articleId;

    public function run()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        } else {
            $this->render('index');
        }
    }
}