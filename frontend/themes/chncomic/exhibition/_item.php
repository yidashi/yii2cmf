<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 下午2:21
 */
use common\helpers\Html;
use common\helpers\Url;

?>
<div class="media-body">
    <h4 class="media-heading">
        <a href="<?= Url::to(['article/view', 'id' => $model->id]) ?>">
            <?= $model->title ?>
        </a>
    </h4>
    <div class="media-content">
        <p><?= $model->desc ?></p>
        <div>
            <span>举办城市: <?= $model->sameCityExhibition->city ?></span>
            <span>举办时间: <?= Yii::$app->formatter->asDate($model->sameCityExhibition->start_at) ?> - <?= Yii::$app->formatter->asDate($model->sameCityExhibition->end_at) ?></span>
        </div>
    </div>
    <div class="media-action">
        <span class="views"><?= Html::icon('eye')?> 浏览 <?= $model->trueView?></span>
        <span class="comments"><?= Html::a(Html::icon('comments-o') . '评论' . $model->comment, ['article/view', 'id' => $model->id, '#' => 'comments'])?></span>
    </div>
</div>
