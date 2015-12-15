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
                if(XMLHttpRequest.status == 302){
                    $('#modal').modal({ remote: XMLHttpRequest.getResponseHeader('X-Redirect')});
                }
                this.abort();

            }
        });
        return false;
    });
    //详细页收藏
    $('.favourites a').on('click', function() {
        var a = $(this);
        var span = $(this).find('span');
        var em = $(this).find('em');
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    span.attr('class', 'fa fa-star');
                    a.attr('data-original-title', '您已收藏').tooltip('show').attr('data-original-title', '取消收藏');
                } else {
                    span.attr('class', 'fa fa-star-o');
                    a.attr('data-original-title', '您已取消收藏').tooltip('show').attr('data-original-title', '收藏');
                }
                em.html(data.count);
            },
            error: function (XMLHttpRequest, textStatus) {
                if(XMLHttpRequest.status == 403){
                    $('#modal').modal({ remote: XMLHttpRequest.responseJSON.message});
                }
                //this.abort();
            }
        });
        return false;
    });
    //回复
    $(".reply-btn").click(function(){
        $(".reply-form").removeClass("hidden");
        if($(this).parent().attr("class")=="media-action") {
            $(".reply-form").appendTo($(this).parent());
            $(".reply-form").find("textarea").val("");
        } else {
            $(".reply-form").appendTo($(this).parents("li").find(".media-action"));
            $(".reply-form").find("textarea").val("@"+$(this).parents(".media-heading").find("a").html()+" ");
        }
        $(".reply-form").find(".parent_id").val($(this).parents("li").attr("data-key"));
        return false;
    });
});