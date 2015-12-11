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
            <div class="pull-left">
                <!-- JiaThis Button BEGIN -->
                <div class="jiathis_style">
                    <a class="jiathis_button_qzone"></a>
                    <a class="jiathis_button_tsina"></a>
                    <a class="jiathis_button_tqq"></a>
                    <a class="jiathis_button_weixin"></a>
                    <a class="jiathis_button_renren"></a>
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                </div>
                <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                <!-- JiaThis Button END -->
            </div>
            <span class="pull-right"><?= date('Y-m-d H:i', $created_at) ?></span>
        </div>
    </div>
    <div class="view-content"><?= \yii\helpers\Markdown::process($content) ?></div>
    <h4>评论</h4>
    <!-- 多说评论框 start -->
    <div class="ds-thread" data-thread-key="<?=$id?>" data-title="<?=$title?>" data-url="<?=Yii::$app->request->url?>"></div>
    <!-- 多说评论框 end -->
    <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
    <script type="text/javascript">
        var duoshuoQuery = {short_name:"51siyuan"};
        (function() {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';ds.async = true;
            ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0]
            || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>
    <!-- 多说公共JS代码 end -->
</div>

