<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/13
 * Time: 下午2:57
 */

namespace frontend\widgets\reward;


use yii\base\Widget;
use frontend\models\RewardForm;
use Yii;

class RewardWidget extends Widget
{

    public $articleId;

    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            //打赏
            $rewardModel = new RewardForm();
            $rewardModel->money = Yii::$app->user->identity->profile->money;
            $rewardModel->article_id = $this->articleId;
            return $this->render('index', [
                'rewardModel' => $rewardModel
            ]);
        } else {
            Yii::$app->user->loginRequired();
        }
    }
}