<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 下午2:21
 */

$this->title = '搜索_' . $q;
?>
<div class="page-header">
    <h2>搜索 - <?= \yii\helpers\Html::encode($q) ?></h2>
    <em class="pull-right">共<?= $dataProvider->totalCount ?>条</em>
</div>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'viewParams' => ['q' => $q],
    'layout' => "{items}\n{pager}",
    'options' => ['class' => 'article-list'],
    'itemOptions' => ['class' => 'media']
]) ?>
