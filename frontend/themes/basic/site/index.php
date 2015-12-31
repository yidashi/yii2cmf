<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['seoTitle'] . '_' . Yii::$app->name;
$this->registerMetaTag(['property' => 'qc:admins', 'content' => '376655717261261166107']);
?>
<div class="site-index">
    <div class="col-md-8">
        <div class="row mb15">
            <div id="carousel-example-generic" class="carousel" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php foreach($slider as $k => $item): ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?=$k ?>" <?php if($k == 0): ?>class="active"<?php endif; ?>></li>
                    <?php endforeach; ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php foreach($slider as $k => $item): ?>
                    <div class="item<?php if($k == 0){echo ' active';}?>">
                        <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item->id])?>" target="_blank">
                            <img src="<?= $item->cover?>" alt="<?= $item->title?>">
                            <div class="carousel-caption">
                                <h3><?= $item->title?></h3>
                                <p><?= $item->desc?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="article-list">
                <h2>今日最新</h2>
                <?php foreach($news as $item):?>
                    <div class="col-md-4 article-item">
                        <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>" target="_blank">
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
            <div class="article-list">
                <?php foreach($recommend as $item):?>
                    <div class="media">
                        <div class="media-left">
                            <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>">
                                <img class="media-object" src="<?= $item->cover?>" alt="<?= $item->title?>" width="160" height=80">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>"><?= $item->title?></a>
                            </h4>
                            <div class="media-action"><?= date('Y-m-d', $item->created_at) ?></div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
    </div>
</div>
<?php $this->registerJs("$('.carousel').carousel();")?>
