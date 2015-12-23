<?php

/* @var $this yii\web\View */

$this->title = '微信热文精选,微信文章,微信分享,微信美文收录,微信公众号和热门文章,微信大全,微信朋友圈好文章_' . Yii::$app->name;
$this->registerMetaTag(['property' => 'qc:admins', 'content' => '376655717261261166107']);
?>
<div class="site-index">
    <h2>今日最新</h2>
    <div class="row">
        <div class="article-list">
            <?php foreach($news as $item):?>
            <div class="col-sm-6 col-md-3 article-item">
                <a href="<?= \yii\helpers\Url::toRoute(['article/view','id'=>$item['id']])?>">
                <img onerror="this.src='http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'" src="<?= $item['cover'] ?: 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png'?>" alt="<?= $item['title']?>" width="200" height="145">
                <h3 class="article-title"><?= $item['title']?></h3>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
