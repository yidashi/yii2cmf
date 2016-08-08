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
        <a href="<?= Url::to(['/user/default/index', 'id' => $model->from_uid]) ?>"><?= $model->from->username ?></a> 发布于 <span><?= Yii::$app->formatter->asRelativeTime($model->data->created_at) ?></span>
    </div>
    <div class="media-content">
        <p><?= $model->data->content ?></p>
    </div>
    <div class="media-action">
        <span><a href="<?= Url::to(['/message/default/create', 'id' => $model->from_uid]) ?>">回复</a></span>
    </div>
</div>
