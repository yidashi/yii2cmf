<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = '留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">
    <div class="panel-heading clearfix">
        <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-primary">留言</a>
    </div>
    <div class="panel-body">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => "{items}",
            'options' => ['class' => 'article-list'],
            'itemOptions' => ['class' => 'media']
        ]) ?>
    </div>
    <div class="panel-footer">
        <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->getPagination()
        ]) ?>
    </div>
</div>
