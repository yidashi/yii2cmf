<?php
/**
 * author: yidashi
 * Date: 2016/1/12
 * Time: 17:05.
 */

use yii\helpers\Html;

$this->title = $page->title;
$this->params['breadcrumbs'][] = $this->title;
list($this->title, $this->params['SEO_SITE_KEYWORDS'], $this->params['SEO_SITE_DESCRIPTION']) = $page->getMetaData();
?>
<style>
    .page-content img{max-width:95%;display:block;margin:0 auto;}
</style>
<div class="col-md-9">
    <div class="page-header text-center">
        <h1><?= $page->title?></h1>
    </div>
    <div class="page-content">
        <?= $page->getProcessedContent()?>
    </div>
    <?= \frontend\widgets\comment\CommentWidget::widget([
        'model' => $page
    ]) ?>
</div>
<div class="col-md-3">
    <?= \common\modules\area\widgets\AreaWidget::widget([
        'slug' => 'page-index-sidebar',
        "blockClass"=>"panel panel-default",
        "headerClass"=>"panel-heading",
        "bodyClass"=>"panel-body",
    ])?>
</div>
