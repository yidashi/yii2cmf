<?php

/* @var $this yii\web\View */

$this->title = '列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <ul class="list-unstyled">
    <?php foreach($models as $item):?>
    <li><a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>"><?= $item['title']?></a></li>
    <?php endforeach;?>
    </ul>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
