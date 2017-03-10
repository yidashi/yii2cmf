<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 下午2:07
 */

namespace common\widgets\scroll;


use yii\base\Widget;
use yii\helpers\Html;

class Scroll extends Widget
{
    public function run()
    {
        echo Html::beginTag('div', ['class' => 'fixed-btn']);
        echo '<a class="back-to-top"><span class="fa fa-arrow-up"></span></a>';
        echo '<a class="qrcode"><i class="fa fa-qrcode"></i></a>';
        echo '<a class="app"><i class="fa fa-mobile-phone"></i></a>';
        echo Html::endTag('div');
        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        $this->view->registerCss(<<<CSS
.fixed-btn {
    position: fixed;
    right: 2%;
    bottom: 100px;
    width: 40px;
    border: 1px solid #eeeeee;
    background-color: white;
    font-size: 24px;
    z-index: 1040;
    -webkit-backface-visibility: hidden;
}
/* 回到顶部开始 */
.fixed-btn a {
    display: inline-block;
    width: 40px;
    height: 40px;
    text-align: center;
}
.back-to-top {display: none;}
.fixed-btn a:hover {
    border-color: #adadad;
    background-color: #e6e6e6;
    color: #333;
    cursor: pointer;
}
/* 回到顶部结束 */
CSS
        );
        $qrcode = \Yii::$app->config->get('wx.qrcode');
        $app = \Yii::$app->config->get('app.download_qrcode');
        $this->view->registerJs(<<<JS
// back-to-top
    $(window).scroll(function(){
        if ($(this).scrollTop() > 500) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    $(".back-to-top").click(function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    $('.qrcode').popover({
        placement:'left',
        html:true,
        title:'关注公众号',
        content:'<img src="{$qrcode}" width="128" height="128">'
    });
    $('.app').popover({
        placement:'left',
        html:true,
        title:'下载app',
        content:'<img src="{$app}" width="128" height="128">'
    });
JS
        );
    }
}