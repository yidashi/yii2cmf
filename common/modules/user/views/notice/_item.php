<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:48
 */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="media-left">
    <a href="<?= Url::to(['/user/default/index', 'id' => $model->from_uid]) ?>" rel="author" data-original-title="" title="">
        <?= Html::img($model->from->getAvatar(), ['class' => 'media-object', 'alt' => $model->from->username]) ?>
    </a>
</div>
<div class="media-body">
    <div class="media-heading">
        <?= $model->title ?>
    </div>
    <div class="media-content">
        <p><?= $model->content ?></p>
    </div>
    <div class="media-action">
        <span><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
        <?php if (!empty($model->link)): ?>
        <span class="pull-right"><a href="<?= $model->link ?>">查看</a></span>
        <?php endif; ?>
    </div>
</div>
