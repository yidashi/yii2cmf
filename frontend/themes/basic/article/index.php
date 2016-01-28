<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['seoTitle'].'_'.$category->title.'_'.Yii::$app->name;
$this->params['breadcrumbs'][] = $category->title;
?>
<div class="site-index">
        <!--<div class="article-list">
            <?php foreach ($models as $item):?>
                <div class="col-sm-6 col-md-3 article-item">
                    <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>">
                        <img onerror="this.src='http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'" src="<?= $item['cover'] ? (strpos($item['cover'], 'http://') === false ? (Yii::getAlias('@static').$item['cover']) : $item['cover']) : 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'?>" alt="<?= $item['title']?>" width="200" height="145">
                        <h3 class="article-title"><?= $item['title']?></h3>
                    </a>
                </div>
            <?php endforeach;?>
        </div>-->
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
                <?php if (!empty($item['cover'])):?>
                <div class="media-right">
                    <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank">
                        <img class="media-object" src="<?=strpos($item['cover'], 'http://') === false ? (Yii::getAlias('@static').'/'.$item['cover']) : $item['cover']?>" alt="<?= $item['title']?>" style="width:64px;height:64px;" onerror="$(this).parents('.media-right').remove()">
                    </a>
                </div>
                <?php endif; ?>
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