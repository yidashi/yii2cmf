<?php
/* @var $this yii\web\View */
/* @var $commentModel common\models\Comment */
/* @var $hots common\models\Article */
/* @var $commentModels common\models\Comment */
/* @var $pages yii\data\Pagination */
use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['/article/index', 'cate' => \common\models\Category::find()->where(['id' => $model->category_id])->select('name')->scalar()]];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="col-lg-9">
    <div class="view-title">
        <h1><?= $model->title ?></h1>
    </div>
    <div class="action">
        <span class="user"><a href="/user/31325"><span class="fa fa-user"></span> <?= $model->author?></a></span>
        <span class="time"><span class="fa fa-clock-o"></span> <?= date('Y-m-d H:i', $model->created_at) ?></span>
        <span class="views"><span class="fa fa-eye"></span> <?= $model->trueView?>次浏览</span>
        <span class="comments"><a href="#comments"><span class="fa fa-comments-o"></span> <?=$model->comment?>条评论</a></span>
        <span class="favourites"><a href="/favourite?type=extension&amp;id=601" title="" data-toggle="tooltip" data-original-title="收藏"><span class="fa fa-star-o"></span> <em>0</em></a></span>
        <span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $model->id, 'type' => 'article', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em><?=$model->up?></em></a><a class="down" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $model->id, 'type' => 'article', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em><?=$model->down?></em></a></span>
    </div>
    <ul class="tag-list list-inline">
        <?php foreach($model->tags as $tag): ?>
        <li><a class="label label-<?= $tag->level ?>" href="<?= \yii\helpers\Url::to(['article/tag', 'name' => $tag->name])?>"><?= $tag->name ?></a></li>
        <?php endforeach; ?>
    </ul>
    <!--内容-->
    <div class="view-content"><?= \yii\helpers\Markdown::process($model->data->content) ?></div>
    <?php if (!empty($model->source)):?><div class="well well-sm">原文链接: <?= $model->source?></div><?php endif;?>
    <div class="well">带到手机上看<?= Html::img(\yii\helpers\Url::to(['/qrcode', 'text' => Yii::$app->request->absoluteUrl])) ?></div>

    <!--分享-->
    <?= \common\widgets\share\Share::widget()?>
    <?= $this->render('comment', ['model' => $model, 'commentModel' => $commentModel, 'commentModels' => $commentModels, 'pages' => $pages, 'commentDataProvider' => $commentDataProvider])?>
</div>
<div class="col-lg-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            热门<?=$model->category?>
        </div>
        <div class="panel-body">
            <ul class="post-list">
                <?php foreach ($hots as $item):?>
                <li><?=Html::a($item->title, ['/article/view', 'id' => $item->id])?></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?= \common\widgets\danmu\Danmu::widget(['id' => $model->id]);?>
<?php
$this->registerJsFile('@web/js/jquery.lazyload.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(<<<js
    $(function(){
        $('.view-content iframe').addClass('embed-responsive-item').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $("img.lazy").show().lazyload({effect: "fadeIn"});
    });
js
);
?>
