<?php
/* @var $this yii\web\View */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => $category,'url' => ['article/' . $category_id]];
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-index">
    <div class="view-title ">
        <h1><?= $title ?></h1>
        <div class="clearfix">
            <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
            <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
            <span class="pull-right"><?= date('Y-m-d H:i', $created_at) ?></span>
        </div>
    </div>
    <div class="view-content"><?= \yii\helpers\Markdown::process($content) ?></div>
    <h4>评论</h4>
    <div class="col-4">
        <?=\common\widgets\markdown\Markdown::widget([
            'name'=>'content',
            'value'=>'',
            'options'=>['style'=>'height:200px;']
        ])?>
    </div>
</div>
