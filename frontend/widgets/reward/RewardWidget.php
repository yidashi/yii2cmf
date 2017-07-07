<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午4:56
 */

namespace frontend\widgets\reward;


use Yii;
use yii\base\Widget;

class RewardWidget extends Widget
{
    public $articleId;

    public function run()
    {
        $model = new RewardForm();
        $model->money = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->profile->money;
        $model->article_id = $this->articleId;
        return $this->render('index', ['model' => $model]);
    }
}