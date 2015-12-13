<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category,'url' => ['/article/index', 'cid' => $model->category_id]];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="col-lg-9">
    <div class="view-title">
        <h1><?= $model->title ?></h1>
    </div>
    <div class="action">
        <span class="user"><a href="/user/31325"><span class="fa fa-user"></span> <?= $model->author?></a></span>
        <span class="time"><span class="fa fa-clock-o"></span> <?= date('Y-m-d H:i', $model->created_at) ?></span>
        <span class="views"><span class="fa fa-eye"></span> 118次浏览</span>
        <span class="comments"><a href="#comments"><span class="fa fa-comments-o"></span> <?=$model->comment?>条评论</a></span>
        <span class="favourites"><a href="/favourite?type=extension&amp;id=601" title="" data-toggle="tooltip" data-original-title="收藏"><span class="fa fa-star-o"></span> <em>0</em></a></span>
        <span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['digg/up','id'=>$model->id, 'type'=>'article'])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em>0</em></a><a class="down" href="<?=\yii\helpers\Url::to(['digg/down','id'=>$model->id, 'type'=>'article'])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em>0</em></a></span>
    </div>
    <div class="view-content"><?= \yii\helpers\Markdown::process($model->content) ?></div>
    <?= \common\widgets\share\Share::widget()?>
    <div id="comments">
        <h4>共 <span class="text-danger"><?=$model->comment?></span> 条评论</h4>
        <div class="col-4">
            <ul class="media-list">
                <?php foreach($commentModels as $item):?>
                <li class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="http://www.yiichina.com/uploads/avatar/000/03/21/32_avatar_small.jpg" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="media-heading"><a href=""><?=$item->user->username?></a> 评论于 <?=date('Y-m-d H:i', $item->created_at)?></div>
                        <div class="media-content"><?= $item->content?></div>
                        <div class="media-action">
                            <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['digg/up','id'=>$item->id, 'type'=>'comment'])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em>0</em></a><a class="down" href="<?=\yii\helpers\Url::to(['digg/up','id'=>$item->id, 'type'=>'comment'])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em>0</em></a></span>
                        </div>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>
    <h4>发表评论</h4>
    <?php if(!Yii::$app->user->isGuest): ?>
        <?php $form = \yii\widgets\ActiveForm::begin(['action'=>\yii\helpers\Url::toRoute('comment/create')]); ?>
        <?= $form->field($commentModel, 'content')->label(false)->widget('\common\widgets\markdown\Markdown',['options'=>['style'=>'height:200px;']]); ?>
        <?= Html::hiddenInput(Html::getInputName($commentModel,'article_id'), $model->id) ?>
        <div class="form-group">
            <?= Html::submitButton('提交',['class'=>'btn btn-primary']) ?>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    <?php else: ?>
        <div class="well">您需要登录后才可以评论。<?=Html::a('登录',['site/login'])?> | <?=Html::a('立即注册', ['site/signup'])?></div>
    <?php endif; ?>
</div>
<div class="col-lg-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            热门<?=$model->category?>
        </div>
            <ul class="list-group">
                <?php foreach($hots as $item):?>
                <li class="list-group-item"><?=Html::a($item->title,['/article/view','id'=>$item->id])?></li>
                <?php endforeach;?>
            </ul>
    </div>
</div>
<?= \common\widgets\danmu\Danmu::widget(['id'=>$model->id]);?>
<?php $this->registerJs(<<<js
    $(function(){
        $('.view-content iframe').addClass('embed-responsive-item').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    });
js
);
