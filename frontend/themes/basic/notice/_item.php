<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:48
 */
use common\helpers\Url;

?>
<div class="media-left">
    <a href="<?= Url::to(['/user', 'id' => $model->from_uid]) ?>" rel="author" data-original-title="" title="">
        <img class="media-object" src="" alt="">
    </a>
</div>
<div class="media-body">
    <div class="media-heading">
        <a href="<?= Url::to(['/user', 'id' => $model->from_uid]) ?>" rel="author" data-original-title="" title="">yidashi</a>
        <?= $model->content ?>
<!--        <a href="/topic/6134">文档bug</a>-->
    </div>
    <div class="media-content">
        <p>+10086</p>
    </div>
    <div class="media-action">
        <span><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
        <span class="pull-right"><a href="/topic/6134">查看</a></span>
    </div>
</div>
