<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 下午2:07
 */

namespace common\widgets\scroll;


use yii\base\Widget;

class Scroll extends Widget
{
    public function run()
    {
        $html = '<a class="back-to-top" style="display: none;"><span class="fa fa-arrow-up"></span></a>';
        $this->view->registerCss(<<<CSS
/* 回到顶部开始 */
.back-to-top {
    position: fixed;
    bottom: 100px;
    right: 2px;
    padding: 3px 8px;
    font-size: 24px;
    color: #666;
    display: none;
    background-color: #fff;
    border:1px solid #ccc;
    border-radius:4px;
    cursor: pointer;
}
.back-to-top:hover {
    border-color:#adadad;
    background-color: #e6e6e6;
    color:#333;
}
/* 回到顶部结束 */
CSS
);
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
JS
        );
        return $html;
    }
}