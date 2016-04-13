<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/13
 * Time: 下午2:57
 */

namespace frontend\components\reward;


use yii\base\Widget;
use frontend\models\RewardForm;

class RewardWidget extends Widget
{
    public $articleId;
    public function run()
    {
        //打赏
        $rewardModel = new RewardForm();
        $rewardModel->money = '2.00';
        $rewardModel->article_id = $this->articleId;
        return $this->render('index', [
            'rewardModel' => $rewardModel
        ]);
    }
}