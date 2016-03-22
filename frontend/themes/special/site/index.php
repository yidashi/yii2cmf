<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['seoTitle'].'_'.Yii::$app->name;
?>
<div class="site-index">
    <div class="col-md-8">
        <div class="row mb15">
            <?php
            $items = [];
            foreach ($slider as $k => $item) {
                $items[$k]['content'] = \yii\helpers\Html::a(
                    \yii\helpers\Html::img($item->cover),
                    \yii\helpers\Url::toRoute(['article/view', 'id' => $item->id]),
                    ['target' => '_blank']
                );
                $items[$k]['caption'] = '<h3>'.$item->title.'</h3><p>'.$item->desc.'</p>';
            }
            echo \yii\bootstrap\Carousel::widget([
                'items' => $items,
                'controls' => false,
            ]);
            ?>
        </div>
        <div class="row mb15">
            <div class="article-list">
                <div class="page-header"><h2>今日最新</h2></div>
                <?php foreach ($news as $item):?>
                    <div class="col-md-4 article-item">
                        <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank">
                            <div class="article-img-wrap">
                                <img src="<?= $item->cover?>" alt="<?= $item->title?>">
                            </div>
                            <h3 class="article-title"><?= $item['title']?></h3>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header"><h2>今日最热</h2></div>
        <div class="article-list">
            <?php foreach ($recommend as $item):?>
                <div class="media">
                    <div class="media-left">
                        <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank">
                            <img class="media-object" src="<?= $item->cover?>" alt="<?= $item->title?>" width="160" height=80">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="<?= \yii\helpers\Url::toRoute(['article/view', 'id' => $item['id']])?>" target="_blank"><?= $item->title?></a>
                        </h4>
                        <div class="media-action"><?= date('Y-m-d', $item->created_at) ?></div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
