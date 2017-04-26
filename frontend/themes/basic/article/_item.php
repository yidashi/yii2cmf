<?php
/* @var $this \yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['article/view', 'id' => $model->id])?>"><?= $model->title?></a>
        <em>[<?= $model->category ?>]</em>
        <?php if($model->is_top): ?><span class="label label-primary">置顶</span><?php endif; ?>
        <?php if($model->isReprint): ?><span class="label label-info">转载</span><?php endif; ?>
    </h4>
    <div class="media-content"><?= $model->description ?></div>
    <div class="media-action">
        <span class="user"><a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= $model->user->username?></a></span>
        <span class="time"><?= Html::icon('clock-o')?> <?= Yii::$app->formatter->asRelativeTime($model->published_at) ?></span>
        <span class="views"><?= Html::icon('eye')?> 浏览 <?= $model->trueView?></span>
        <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $model->commentTotal, ['article/view', 'id' => $model->id, '#' => 'comments'])?></span>
    </div>
</div>

<div class="media-right">
    <?php if ($model->cover): ?>
        <a href="<?= Url::to(['article/view', 'id' => $model->id])?>"><?= Html::img($model->cover, ['width' => 160, 'height' => 120]) ?></a>
    <?php endif; ?>
</div>
