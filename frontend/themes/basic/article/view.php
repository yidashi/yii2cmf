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
    <div class="view-content"><?= \yii\helpers\Markdown::process($content) ?></div>
    <h4>评论</h4>
    <div class="col-4">
        <?=\common\widgets\markdown\Markdown::widget([
            'name'=>'content',
            'value'=>'',
            'options'=>['style'=>'height:200px;']
        ])?>
    </div>
</div>
