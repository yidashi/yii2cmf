<?php
/* @var $this yii\web\View */
/* @var $commentModel common\models\Comment */
/* @var $hots common\models\Article */
/* @var $model common\models\Article */
/* @var $prev common\models\Article */
/* @var $next common\models\Article */
/* @var $commentModels common\models\Comment */
/* @var $pages yii\data\Pagination */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['/article/index', 'cate' => \common\models\Category::find()->where(['id' => $model->category_id])->select('slug')->scalar()]];
$this->params['breadcrumbs'][] = Html::encode($model->title);
list($this->title, $this->params['SEO_SITE_KEYWORDS'], $this->params['SEO_SITE_DESCRIPTION']) = $model->getMetaData();
?>
<div class="col-lg-9">
    <div class="view-title">
        <h1><?= Html::encode($model->title) ?></h1>
    </div>
    <div class="action">
        <span class="user"><a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= $model->user->username?></a></span>
        <span class="time"><?= Html::icon('clock-o')?> <?= date('Y-m-d', $model->created_at) ?></span>
        <span class="views"><?= Html::icon('eye')?> <?= $model->trueView?>次浏览</span>
        <span class="comments"><a href="#comments"><?= Html::icon('comments-o')?> <?= $model->commentTotal ?>条评论</a></span>
        <span class="favourites"><?= Html::a(Html::icon($model->isFavourite ? 'star' : 'star-o') . ' <em>' . $model->favourite . '</em>', ['/favourite'], [
                'data-params' => [
                    'id' => $model->id
                ],
                'data-toggle' => 'tooltip',
                'data-original-title' => '收藏'
            ])?>
        </span>
        <!--   打赏作者     -->
        <?= \frontend\widgets\reward\RewardWidget::widget(['articleId' => $model->id])?>
        <span class="vote">
            <a class="up" href="<?= Url::to(['/vote', 'id' => $model->id, 'type' => 'article', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><?= Html::icon($model->isUp ? 'thumbs-up' : 'thumbs-o-up')?> <em><?= $model->upTotal ?></em></a>
            <a class="down" href="<?= Url::to(['/vote', 'id' => $model->id, 'type' => 'article', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><?= Html::icon($model->isDown ? 'thumbs-down' : 'thumbs-o-down')?> <em><?= $model->downTotal ?></em></a></span>
    </div>
    <ul class="tag-list list-inline">
        <?php foreach($model->tags as $tag): ?>
            <li><a class="label label-<?= $tag->level ?>" href="<?= Url::to(['article/tag', 'name' => $tag->name])?>"><?= $tag->name ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="exhibition-info well">
        <p class="exhibition-address"><?= Html::icon('map-pin') ?> <?= $model->data->city ?> <?= $model->data->address ?></p>
        <p class="exhibition-time"><?= Html::icon('clock-o') ?> <?= $model->data->start_at ?> 至 <?= $model->data->end_at ?></p>
    </div>
    <!--内容-->
    <div class="view-content"><?= \yii\helpers\HtmlPurifier::process($model->description) ?></div>
    <?php if (!empty($model->source)):?><div class="well well-sm">原文链接: <?= $model->source?></div><?php endif;?>
    <nav>
        <ul class="pager">
            <?php if ($prev != null): ?>
                <li class="previous"><a href="<?= Url::to(['view', 'id' => $prev->id]) ?>">&larr; 上一篇</a></li>
            <?php else: ?>
                <li class="previous"><a href="javascript:;">&larr; 已经是第一篇</a></li>
            <?php endif; ?>
            <?php if ($next != null): ?>
                <li class="next"><a href="<?= Url::to(['view', 'id' => $next->id]) ?>">下一篇 &rarr;</a></li>
            <?php else: ?>
                <li class="next"><a href="javascript:;">已经是最后一篇 &rarr;</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <!--分享-->
    <?= \common\widgets\share\Share::widget()?>
    <!-- 评论   -->
    <?= \frontend\widgets\comment\CommentWidget::widget(['entityId' => $model->id]) ?>
</div>
<div class="col-lg-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media media-user">
                <div class="media-left">
                    <a href="<?= url(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::img($model->user->getAvatar(), ['class' => 'media-object', 'alt' => $model->user->username]) ?></a>
                    <div class="label label-primary"><?= $model->user->getLevel()['nick'] ?></div>
                </div>
                <div class="media-body">
                    <h2 class="media-heading">
                        <a href="<?= url(['/user/default/index', 'id' => $model->user_id]) ?>"><?= $model->user->username ?></a>
                    </h2>
                    <div class="time">注册时间：<?= Yii::$app->formatter->asDate($model->user->created_at) ?><br>最后登录：<?= Yii::$app->formatter->asRelativeTime($model->user->login_at) ?></div>
                </div>

                <div class="media-footer">
                    <ul class="stat">
                        <li>粉丝<h3><?= \common\models\Friend::getFansNumber($model->user_id) ?></h3></li>
                        <li>关注<h3><?= \common\models\Friend::getFollowNumber($model->user_id) ?></h3></li>
                        <li>金钱<h3><?= $model->user->profile->money ?></h3></li>
                    </ul>
                    <a class="follow btn btn-xs <?php if((new \common\models\Friend())->isFollow($model->user_id)): ?>btn-danger <?php else: ?>btn-success <?php endif; ?> <?php if ($model->user_id == Yii::$app->user->id): ?>disabled<?php endif; ?>" href="<?= Url::to(['/friend/follow', 'id' => $model->user_id]) ?>"><?php if (!(new \common\models\Friend())->isFollow($model->user_id)): ?><i class="fa fa-plus"></i> 关注Ta <?php else: ?>取消关注 <?php endif; ?></a>
                    <a class="btn btn-xs btn-primary <?php if ($model->user_id == Yii::$app->user->id): ?>disabled<?php endif; ?>" href="<?= Url::to(['/message/default/create', 'id' => $model->user_id]) ?>"><i class="fa fa-envelope"></i> 发私信</a>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-success btn-block" href="<?= url(['/user/default/create-article']) ?>"><i class="fa fa-plus"></i> 发布</a>
    <?php if (Yii::$app->user->id == $model->user_id) : ?>
    <a class="btn btn-primary btn-block" href="<?= url(['/user/default/update-article', 'id' => $model->id]) ?>"><i class="fa fa-pencil"></i> 修改</a>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading">带到手机上看</div>
        <div class="panel-body">
            <?= Html::img(Url::to(['/qrcode', 'text' => Yii::$app->request->absoluteUrl])) ?>
        </div>
    </div>
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
<?php $this->registerJs("$('.view-content a').attr('target', '_blank');") ?>
