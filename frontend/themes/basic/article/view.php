<?php

/* @var $this yii\web\View */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => $category,'url' => ['article/' . $category_id]];
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-index">
    <div class="view-title ">
        <h1><?= $title ?></h1>
        <div class="clearfix"><span class="pull-right"><?= date('Y-m-d H:i', $created_at) ?></span></div>
    </div>
    <div class="view-content"><?= $content ?></div>
</div>
