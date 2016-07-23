<?php

use common\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

?>

    <div class="col-md-9">
        <?= \frontend\widgets\slider\CarouselWidget::widget([
            'key'=>'index',
            'options' => [
                'class' => 'slide',
            ],
        ]) ?>
        <div class="page-header"><h2>最新文章</h2></div>
        <div class="article-list">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'media'],
                'itemView' => '_item',
                'layout' => "{items}\n{pager}"
            ]) ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <?php if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSign)): ?>
            <a class="btn btn-success btn-registration" href="<?= Url::to(['/sign'])?>"><i class="fa fa-calendar-plus-o"></i> 点此处签到<br>签到有好礼</a>
            <?php else: ?>
            <a class="btn btn-success disabled" href="<?= Url::to(['/sign'])?>"><i class="fa fa-calendar-check-o"></i> 今日已签到<br>已连续<?= Yii::$app->user->identity->sign->continue_times ?>天</a>
            <?php endif; ?>
            <a class="btn btn-primary" href="<?= Url::to(['/sign'])?>"><?= date('Y年m月d日') ?><br>今日已有<?= Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{%sign}} WHERE FROM_UNIXTIME(last_sign_at, "%Y%m%d") = "'. date('Ymd') . '"')->queryScalar() ?>人签到</a>
        </div>
        <?= \frontend\widgets\area\AreaWidget::widget([
            'slug' => 'sidebar',
            "blockClass"=>"panel panel-default",
            "headerClass"=>"panel-heading",
            "bodyClass"=>"panel-body",
        ])?>
        <div class="panel panel-default">
            <div class="panel-heading"><h2>所有分类</h2></div>
            <div class="panel-body">
                <ul class="post-list">
                <?php foreach ($categorys as $item):?>
                    <li><a href="<?= Url::to(['/article/index', 'cate' => $item->slug])?>"><?= $item->title?> <span class="pull-right badge"><?= $item->article?></span></a></li>
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
                        <li><a class="label label-<?= $tag->level ?>" href="<?= Url::to(['article/tag', 'name' => $tag->name])?>"><?= $tag->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php $this->trigger('indexSideBar') ?>
    </div>