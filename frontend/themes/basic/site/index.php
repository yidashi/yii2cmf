<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['seoTitle'] . '_' . Yii::$app->name;
$this->registerMetaTag(['property' => 'qc:admins', 'content' => '376655717261261166107']);
?>
<div class="site-index">
    <div class="row">
        <div class="mb15">
            <h2>今日最热</h2>
            <div id="carousel-example-generic" class="carousel" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php foreach($recommend as $k => $item): ?>
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

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="article-list mb15">
            <h2>今日最新</h2>
            <?php foreach($news as $item):?>
            <div class="col-sm-6 col-md-3 article-item">
                <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>" target="_blank">
                    <img onerror="this.src='http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'" src="<?= $item['cover']?>" alt="<?= $item['title']?>" width="200" height="145">
                <h3 class="article-title"><?= $item['title']?></h3>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php $this->registerJs("$('.carousel').carousel();")?>
