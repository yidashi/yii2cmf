<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <h2>最新动态</h2>
    <ul class="list-unstyled">
        <?php foreach($news as $item):?>
            <li><a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>"><?= $item['title']?></a></li>
        <?php endforeach;?>
    </ul>
</div>
