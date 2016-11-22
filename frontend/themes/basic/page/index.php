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
<div class="page-header text-center">
    <h1><?= $page->title?></h1>
</div>
<div class="col-md-9">
<div class="page-content">
    <?= $page->content?>
</div>
<?= \frontend\widgets\comment\CommentWidget::widget([
    'type' => 'page',
    'type_id' => $page->id,
]) ?>
</div>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            最热文章
        </div>
        <div class="panel-body">
            <ul class="post-list">
                <?php foreach (\frontend\models\Article::hots() as $item):?>
                    <li><?= Html::a($item->title, ['/article/view', 'id' => $item->id])?></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <?= \frontend\widgets\area\AreaWidget::widget([
        'slug' => 'page-index-sidebar',
        "blockClass"=>"panel panel-default",
        "headerClass"=>"panel-heading",
        "bodyClass"=>"panel-body",
    ])?>
</div>
