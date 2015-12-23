<?php

/* @var $this yii\web\View */

$this->title = $category . '_' . Yii::$app->name;
$this->params['breadcrumbs'][] = $category;
?>
<div class="site-index">
    <div class="row">
        <div class="article-list">
            <?php foreach($models as $item):?>
                <div class="col-sm-6 col-md-3 article-item">
                    <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>">
                        <img onerror="this.src='http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'" src="<?= $item['cover']? (Yii::getAlias('@static') . $item['cover']) : 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'?>" alt="<?= $item['title']?>" width="200" height="145">
                        <h3 class="article-title"><?= $item['title']?></h3>
                    </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>