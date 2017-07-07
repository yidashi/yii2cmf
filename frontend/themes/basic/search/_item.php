<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 下午2:21
 */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['article/view', 'id' => $model->id]) ?>">
            <?= Html::weight($q, $model->title) ?>
        </a>
    </h4>
    <div class="media-action">
        <span class="views"><?= Html::icon('eye')?> 浏览 <?= $model->trueView?></span>
        <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $model->commentTotal, ['article/view', 'id' => $model->id, '#' => 'comments'])?></span>
    </div>
</div>
