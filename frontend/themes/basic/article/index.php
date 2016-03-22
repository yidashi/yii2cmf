<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['seoTitle'].'_'.$category->title.'_'.Yii::$app->name;
$this->params['breadcrumbs'][] = $category->title;
?>
<div class="row">
    <div class="col-8">
        <div class="article-list">
            <?php foreach ($models as $item):?>
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank"><?= $item['title']?></a>
                        </h4>
                        <div class="media-content">
                            <span class="views"><span class="fa fa-eye"></span>浏览 <?= $item->view?></span>
                            <span class="comments"><span class="fa fa-comments-o"></span>评论 <?=$item->comment?></span>
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
    <div class="col-4">

    </div>
</div>
