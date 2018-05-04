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
    <a href="<?= Url::to(['/user/default/index', 'id' => $model->from_uid]) ?>">
        <?= Html::img($model->from->getAvatar(), ['class' => 'media-object', 'alt' => Html::encode($model->from->username)]) ?>
    </a>
</div>
<div class="media-body">
    <div class="media-heading">
        <a href="<?= Url::to(['/user/default/index', 'id' => $model->from_uid]) ?>"><?= Html::encode($model->from->username) ?></a>
        <?= $model->title ?>
        <?= $model->getEntity() ?>
    </div>
    <div class="media-content">
        <p><?= Html::encode($model->content) ?></p>
    </div>
    <div class="media-action">
        <span><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
        <?php $link = $model->getLink();if (!empty($link)): ?>
        <span class="pull-right"><a href="<?= Url::to($model->getLink()) ?>">查看</a></span>
        <?php endif; ?>
    </div>
</div>
