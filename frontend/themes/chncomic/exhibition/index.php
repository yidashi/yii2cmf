<?php
/* @var $this yii\web\View */

$this->title = '漫展汇';
?>
<div class="page-header"><?= $this->title ?></div>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => "{items}",
    'options' => ['class' => 'article-list'],
    'itemOptions' => ['class' => 'media']
]) ?>