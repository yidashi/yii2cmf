<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

?>
<div class="row">
    <div class="col-md-9">
        <?= \frontend\widgets\slider\CarouselWidget::widget([
            'key'=>'index',
            'options' => [
                'class' => 'mb15',
            ],
        ]) ?>
        <div class="row">
            <?php
            if ($this->beginCache('category-article-list', ['duration' => 3600])):
                ?>
        <?php foreach ($categories as $category):?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $category->title ?></h3>
                        <div class="pull-right"><a href="<?= Url::to(['/article/index', 'cate' => $category->id]) ?>" target="_blank">更多 >></a></div>
                    </div>
                    <div class="panel-body">
                        <ul class="category-article-list">
                            <?php
                                $list = \frontend\models\Article::find()->andWhere(['category_id' => $category->id])->orderBy('id desc')->limit(5)->all();
                            foreach ($list as $item) :
                            ?>
                                <li><em><?= Yii::$app->formatter->asDate($item->published_at, 'php:m-d') ?></em> <a href="<?= Url::to(['/article/view', 'id' => $item->id]) ?>" title="<?= $item->title ?>" target="_blank"><?= $item->title ?></a></li>
                                <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
            <?php $this->endCache();endif; ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <?php if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSign)): ?>
            <a class="btn btn-success btn-registration" href="<?= Url::to(['/sign/index'])?>"><i class="fa fa-calendar-plus-o"></i> 点此处签到<br>签到有好礼</a>
            <?php else: ?>
            <a class="btn btn-success disabled" href="<?= Url::to(['/sign/index'])?>"><i class="fa fa-calendar-check-o"></i> 今日已签到<br>已连续<?= Yii::$app->user->identity->sign->continue_times ?>天</a>
            <?php endif; ?>
            <a class="btn btn-primary" href="<?= Url::to(['/sign/index'])?>"><?= date('Y年m月d日') ?><br>今日已有<?= Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{%sign}} WHERE FROM_UNIXTIME(last_sign_at, "%Y%m%d") = "'. date('Ymd') . '"')->queryScalar() ?>人签到</a>
        </div>
        <?= \common\modules\area\widgets\AreaWidget::widget([
            'slug' => 'site-index-sidebar',
            "blockClass"=>"panel panel-default",
            "headerClass"=>"panel-heading",
            "bodyClass"=>"panel-body",
        ])?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5>活跃用户</h5>
            </div>
            <div class="panel-body">
                <ul class="login-user-list">
                    <?php $users = \common\modules\user\models\User::find()->orderBy('login_at desc')->limit(6)->all();foreach($users as $user): ?>
                        <li class="col-md-4 col-xs-4 mb15">
                            <a href="<?= Url::to(['/user/default/index', 'id' => $user->id]) ?>">
                                <img src="<?= $user->getAvatar(64) ?>" alt="<?= $user->username ?>">
                                <p><?= $user->username ?></p>
                            </a>
                        </li>
                    <?php endforeach; ?>
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5>推荐内容</h5>
            </div>
            <div class="panel-body">
                <ul class="post-list">
                    <?php
                        $recommentList = \frontend\models\Article::tops();
                    foreach ($recommentList as $item):
                    ?>
                    <li><a href="<?= Url::to(['/article/view', 'id' => $item->id]) ?>" title="<?= $item->title ?>" target="_blank"><?= $item->title ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php $this->trigger('indexSideBar') ?>
    </div>
</div>