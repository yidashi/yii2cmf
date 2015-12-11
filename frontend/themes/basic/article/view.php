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
    <div class="col-4">
        <?=\common\widgets\markdown\Markdown::widget([
            'name'=>'content',
            'value'=>'',
            'options'=>['style'=>'height:200px;']
        ])?>
    </div>
</div>
