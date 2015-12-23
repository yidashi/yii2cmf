<?php

/* @var $this yii\web\View */

$this->title = '微信热文精选,微信文章,微信分享,微信美文收录,微信公众号和热门文章,微信大全,微信朋友圈好文章_' . Yii::$app->name;
$this->registerMetaTag(['property' => 'qc:admins', 'content' => '376655717261261166107']);
$this->registerMetaTag(['property' => 'keywords', 'content' => '信热文精选,微信,文章,好文章,微信文摘,美文,微信文章大全,微信公众平台,微信文章,微信文章怎么写,微信文章哪里找,微信文章编辑,微信公众平台,订阅号,微信营销,二维码,伤感文章,情感文章,微信段子']);
$this->registerMetaTag(['property' => 'description', 'content' => '微信热文精选微信文章精选是收录微信文章、微信段子的微信文摘网站。健康,正能量的微信文章，令人阅读受益，更能即刻分享到朋友圈！微信好文章能助力微信分享、微信营销、微信公众平台使用。网站内容涉及,微信文摘,微信文章大全,微信文章集锦,微信分享,微信公众号,服务号,订阅号,微博,心灵鸡汤,励志,情感,男女,文化,职场,人生,家庭,美食,幽默,开心,星座,生肖,人际,社会,新闻,热议,旅游等']);
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
