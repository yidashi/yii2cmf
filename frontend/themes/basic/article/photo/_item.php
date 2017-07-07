<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['article/view', 'id' => $model->id])?>"><?= $model->title?></a>
        <em>[<?= $model->category ?>]</em>
    </h4>
    <div class="media-content">
        <?php foreach ($model->data->photos as $k => $photo): ?>
            <?php if ($k>=3){break;} ?>
            <?= Html::img($photo->getThumb(100, 75), ['width' => 100, 'height' => 75]) ?>
        <?php endforeach; ?>
    </div>
    <div class="media-action">
        <span class="user"><a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= $model->user->username?></a></span>
        <span class="time"><?= Html::icon('clock-o')?> <?= Yii::$app->formatter->asRelativeTime($model->published_at) ?></span>
        <span class="views"><?= Html::icon('eye')?> 浏览 <?= $model->trueView?></span>
        <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $model->commentTotal, ['article/view', 'id' => $model->id, '#' => 'comments'])?></span>
    </div>
</div>
