<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category,'url' => ['/article/index', 'cid' => $model->category_id]];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="site-index">
    <div class="view-title ">
        <h1><?= $model->title ?></h1>
        <div class="clearfix">
            <div class="pull-left">

            </div>
            <span class="pull-right"><?= date('Y-m-d H:i', $model->created_at) ?></span>
        </div>
    </div>
    <div class="view-content"><?= \yii\helpers\Markdown::process($model->content) ?></div>
    <h4>评论</h4>
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
                    <div class="media-heading"><a href=""><?=$item->user_id?></a> 评论于 <?=$item->created_at?></div>
                    <div class="media-content"><?= $item->content?></div>
                    <div class="media-action">
                        <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="/vote?type=comment&amp;action=up&amp;id=1946" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em>0</em></a><a class="down" href="/vote?type=comment&amp;action=down&amp;id=1946" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em>0</em></a></span>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
    <h4>发表评论</h4>
    <?php if(!Yii::$app->user->isGuest): ?>
        <?php $form = \yii\widgets\ActiveForm::begin(['action'=>\yii\helpers\Url::toRoute('comment/create')]); ?>
        <?= $form->field($commentModel, 'content')->widget('\common\widgets\markdown\Markdown',['options'=>['style'=>'height:200px;']]); ?>
        <?= Html::hiddenInput(Html::getInputName($commentModel,'article_id'), $model->id) ?>
        <div class="form-group">
            <?= Html::submitButton('提交',['class'=>'btn btn-primary']) ?>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    <?php else: ?>
        请先登录
    <?php endif; ?>
</div>

