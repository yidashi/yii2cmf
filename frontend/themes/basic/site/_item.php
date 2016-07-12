<?php
/* @var $this \yii\web\View */
use common\helpers\Url;
use common\helpers\Html;
?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['article/view', 'id' => $model->id])?>"><?= $model->title?></a>
        <em>[<?= $model->category ?>]</em>
        <?php if($model->is_top): ?><span class="top-label">置顶</span><?php endif; ?>
    </h4>
    <div class="media-content"><?= $model->desc ?></div>
    <div class="media-action">
        <span class="user"><a href="<?= Url::to(['/user', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= $model->user->username?></a></span>
        <span class="time"><?= Html::icon('clock-o')?> <?= Yii::$app->formatter->asRelativeTime($model->published_at) ?></span>
        <span class="views"><?= Html::icon('eye')?> 浏览 <?= $model->trueView?></span>
        <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $model->comment, ['article/view', 'id' => $model->id, '#' => 'comments'])?></span>
    </div>
</div>
