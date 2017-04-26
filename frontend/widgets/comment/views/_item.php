<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:36
 */
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

?>
<div class="media-left">
    <a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id])?>">
        <?= Html::img($model->user->getAvatar(), ['class' => 'media-object', 'alt' => $model->user->username]) ?>
    </a>
</div>
<div class="media-body">
    <div class="media-heading">
        <a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id])?>"><?=$model->user->username?></a>
        发表于 <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:Y-m-d H:i') ?>
        <?php if($model->is_top): ?><span class="label label-primary">置顶</span><?php endif; ?>
    </div>
    <div class="media-content" id="suggest-<?= $model->id ?>"><?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?></div>
    <?php foreach ($model->sons as $son):?>
        <div class="media">
            <div class="media-left">
                <a href="<?= Url::to(['/user/default/index', 'id' => $son->user_id])?>" rel="author" title="">
                    <?= Html::img($son->user->getAvatar(96), ['class' => 'media-object', 'alt' => $son->user->username]) ?>
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <a href="<?= Url::to(['/user/default/index', 'id' => $son->user_id])?>" rel="author" data-original-title="<?=$son->user->username?>" title=""><?=$son->user->username?></a> 回复于 <?=date('Y-m-d H:i', $son->created_at)?>
                    <span class="pull-right"><a class="reply-btn j_replayAt" href="javascript:;">回复</a></span>
                </div>
                <div class="media-content" id="suggest-<?= $son->id ?>"><?= HtmlPurifier::process(Markdown::process(\common\models\Comment::process($son->content))) ?></div>
            </div>
        </div>
    <?php endforeach;?>
    <div class="media-action">
        <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $model->id, 'type' => 'comment', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><i class="fa <?= $model->isUp ? 'fa-thumbs-up' : 'fa-thumbs-o-up' ?>"></i> <em><?= $model->upTotal ?></em></a><a class="down" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $model->id, 'type' => 'comment', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><i class="fa <?= $model->isDown ? 'fa-thumbs-down' : 'fa-thumbs-o-down' ?>"></i> <em><?= $model->downTotal ?></em></a></span>
    </div>
</div>