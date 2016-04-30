<?php

use common\helpers\Html;
/* @var $this yii\web\View */

?>
<div class="site-index">
    <div class="col-md-8">
        <div class="page-header"><h2>最新文章</h2></div>
        <div class="article-list">
            <?php foreach ($dataProvider->models as $item):?>
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>"><?= $item['title']?></a>
                        </h4>
                        <div class="media-content"><?= $item['desc'] ?></div>
                        <div class="media-action">
                            <span class="time"><?= Html::icon('clock-o')?> <?= date('Y-m-d H:i', $item['created_at']) ?></span>
                            <span class="views"><?= Html::icon('eye')?> 浏览 <?= $item->trueView?></span>
                            <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $item->comment, ['article/view', 'id' => $item->id, '#' => 'comments'])?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h2>所有分类</h2></div>
            <div class="panel-body">
                <ul class="post-list">
                <?php foreach ($categorys as $item):?>
                    <li><a href="<?= \yii\helpers\Url::to(['/' . $item->name])?>"><?= $item->title?> <span class="pull-right badge"><?= $item->article?></span></a></li>
                <?php endforeach;?>
                </ul>
            </div>
        </div>
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
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h5>获取源码</h5>
            </div>
            <div class="panel-body">
                <ul class="post-list">
                    <li><a href="https://github.com/yidashi/yii2cmf" target="_blank">github</a></li>
                    <li><a href="https://coding.net/u/yidashi/p/yii2cmf/git" target="_blank">coding</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
