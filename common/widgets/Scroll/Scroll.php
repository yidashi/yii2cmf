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
        $html = '<a class="back-to-top btn btn-default" style="display: none;"><span class="fa fa-arrow-up"></span></a>';
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