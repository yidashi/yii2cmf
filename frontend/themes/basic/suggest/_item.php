<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:36
 */
use yii\helpers\Markdown;
use yii\helpers\Url;
use common\helpers\Html;

?>
<div class="media-left">
    <a href="<?= Url::to(['/user', 'id' => $model->user_id])?>">
        <?= Html::img($model->profile->avatar, ['class' => 'media-object', 'alt' => $model->user->username]) ?>
    </a>
</div>
<div class="media-body">
    <div class="media-heading"><a href="<?= Url::to(['/user', 'id' => $model->user_id])?>"><?=$model->user->username?></a> 发表于 <?=date('Y-m-d H:i', $model->created_at)?></div>
    <div class="media-content"><?= Markdown::process($model->content, 'gfm')?></div>
    <?php foreach ($model->sons as $son):?>
        <div class="media">
            <div class="media-left">
                <a href="<?= Url::to(['/user', 'id' => $son->user_id])?>" rel="author" title="">
                    <?= Html::img($son->profile->avatar, ['class' => 'media-object', 'alt' => $son->user->username]) ?>
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <a href="<?= Url::to(['/user', 'id' => $son->user_id])?>" rel="author" data-original-title="<?=$son->user->username?>" title=""><?=$son->user->username?></a> 回复于 <?=date('Y-m-d H:i', $son->created_at)?>
                    <span class="pull-right"><a class="reply-btn j_replayAt" href="javascript:;">回复</a></span>
                </div>
                <div class="media-content"><?= Markdown::process(\common\helpers\Comment::process($son->content))?></div>
            </div>
        </div>
    <?php endforeach;?>
    <div class="media-action">
        <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><i class="fa <?= $item->isUp ? 'fa-thumbs-up' : 'fa-thumbs-o-up' ?>"></i> <em><?=$item->up?></em></a><a class="down" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><i class="fa <?= $item->isDown ? 'fa-thumbs-down' : 'fa-thumbs-o-down' ?>"></i> <em><?=$item->down?></em></a></span>
    </div>
</div>
