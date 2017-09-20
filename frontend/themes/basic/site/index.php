<?php

use yii\helpers\Url;
use common\models\Article;

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
            <?php if ($this->beginCache('category-article-list', ['dependency' => ['class' => 'yii\caching\DbDependency', 'sql' => "SELECT MAX(updated_at) FROM {{%article}}"]])): ?>
        <?php foreach ($categories as $category):?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-list" aria-hidden="true" style="margin-right: 10px"></span><?= $category->title ?></h3>
                        <div class="pull-right"><a href="<?= Url::to(['/article/index', 'cate' => $category->slug]) ?>" target="_blank">更多 >></a></div>
                    </div>
                    <div class="panel-body">
                        <ul class="category-article-list">
                            <?php
                                $list = Article::find()->published()->andWhere(['category_id' => $category->id])->orderBy('id desc')->limit(5)->all();
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
        <?= \common\modules\area\widgets\AreaWidget::widget([
            'slug' => 'site-index-sidebar',
            "blockClass"=>"panel panel-default",
            "headerClass"=>"panel-heading",
            "bodyClass"=>"panel-body",
        ])?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5 class="panel-title">热门教程</h5>
            </div>
            <div class="panel-body">
                <ul class="post-list">
                    <?php $books = \common\modules\book\models\Book::find()->orderBy('view desc')->limit(5)->all();foreach($books as $book): ?>
                        <li><a href="<?= Url::to(['/book/default/view', 'id' => $book->id]) ?>" title="<?= $book->book_name ?>" target="_blank"><?= $book->book_name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5 class="panel-title">热门标签</h5>
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
                <h5 class="panel-title">推荐内容</h5>
            </div>
            <div class="panel-body">
                <ul class="post-list">
                    <?php
                        $recommentList = \frontend\services\ArticleService::tops();
                    foreach ($recommentList as $item):
                    ?>
                    <li><a href="<?= Url::to(['/article/view', 'id' => $item->id]) ?>" title="<?= $item->title ?>" target="_blank"><?= $item->title ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5 class="panel-title">活跃用户</h5>
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
    </div>
</div>