<?php
/**
 * author: yidashi
 * Date: 2016/1/12
 * Time: 17:05.
 */
$this->title = $page->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header text-center">
    <h1><?= $page->title?></h1>
</div>
<div class="page-content">
    <?= $page->content?>
</div>