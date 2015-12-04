<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
$this->registerMetaTag(['property' => 'qc:admins', 'content' => '376655717261261166107']);
?>
<div class="site-index">
    <h2>今日最新</h2>
    <div class="row">
        <div class="article-list">
            <?php foreach($news as $item):?>
            <div class="col-sm-6 col-md-3 article-item">
                <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>">
                <img src="<?= $item['cover']?>" alt="<?= $item['title']?>" width="200" height="145">
                <h3 class="article-title"><?= $item['title']?></h3>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
