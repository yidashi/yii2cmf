<?php

/* @var $this yii\web\View */
if(isset($category)) {
    $this->title = Yii::$app->params['seoTitle'].'_'.$category->title.'_'.Yii::$app->name;
    $this->params['breadcrumbs'][] = $category->title;
} elseif (isset($tag)) {
    $this->title = Yii::$app->params['seoTitle'].'_'.$tag->name.'_'.Yii::$app->name;
    $this->params['breadcrumbs'][] = $tag->name;
}
?>
<div class="col-lg-8">
    <div class="article-list">
        <?php foreach ($models as $item):?>
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank"><?= $item['title']?></a>
                    </h4>
                    <div class="media-content">
                        <span class="views"><span class="fa fa-eye"></span> 浏览 <?= $item->trueView?></span>
                        <span class="comments"><span class="fa fa-comments-o"></span> 评论 <?=$item->comment?></span>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php if (!(new \Detection\MobileDetect())->isMobile()): ?>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
    <?php else:?>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'nextPageLabel' => '下一页',
        'prevPageLabel' => '上一页',
        'maxButtonCount' => 0,
        'prevPageCssClass' => 'previous',
        'nextPageCssClass' => 'next',
        'options' => ['class' => 'pager'],
    ]); ?>
    <?php endif;?>
</div>
<div class="col-lg-4">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h5>热门标签</h5>
        </div>
        <div class="panel-body">
            <ul class="tag-list list-inline">
                <?php foreach($hotTags as $tag): ?>
                    <li><a class="label label-<?= $tag->level ?>" href="<?= \yii\helpers\Url::to(['article/tag', 'name' => $tag->name])?>"><?= $tag->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
