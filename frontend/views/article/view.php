<?php

/* @var $this yii\web\View */

$this->title = '内容';
$this->params['breadcrumbs'][] = ['label' => '列表','url' => ['article/list']];
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-index">
    <h1><?= $title ?></h1>
    <div><?= $created_at ?></div>
    <?= $content ?>
</div>
