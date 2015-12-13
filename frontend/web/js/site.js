$(function(){
    $("[data-toggle=tooltip]").tooltip({container: 'body'});
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
});