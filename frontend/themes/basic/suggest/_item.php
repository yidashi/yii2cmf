<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\Suggest */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['/suggest/view', 'id' => $model->id])?>"><?= Html::encode($model->title) ?></a>
    </h4>
    <div class="media-action">
        <span class="user"><a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= Html::encode($model->user->username) ?></a></span>
        <span class="time"><?= Html::icon('clock-o')?> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
    </div>
</div>
