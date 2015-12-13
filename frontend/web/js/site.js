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
    //投票
    $('.vote a').on('click', function() {
        var a = $(this);
        var title = a.attr('data-original-title');
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                a.parent().find('.up span').attr('class', 'fa fa-thumbs-o-up');
                a.parent().find('.down span').attr('class', 'fa fa-thumbs-o-down');
                a.find('span').attr('class', a.find('span').attr('class').replace('o-', ''));
                a.parent().find('.up em').html(data.up);
                a.parent().find('.down em').html(data.down);
                a.attr('data-original-title');
                a.attr('data-original-title', '您已' + title).tooltip('show').attr('data-original-title', title);
            },
            error: function (XMLHttpRequest, textStatus) {
                $('#modal').modal({ remote: '/yii/frontend/web/site/login'});
                //this.abort();
            }
        });
        return false;
    });
});