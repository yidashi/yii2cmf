$(function(){
    $("[data-toggle=tooltip]").tooltip({container: 'body'});

    //投票
    $('.vote a').on('click', function() {
        var a = $(this);
        var title = a.attr('data-original-title');
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                a.parent().find('.up i').attr('class', 'fa fa-thumbs-o-up');
                a.parent().find('.down i').attr('class', 'fa fa-thumbs-o-down');
                a.find('i').attr('class', a.find('i').attr('class').replace('o-', ''));
                a.parent().find('.up em').html(data.up);
                a.parent().find('.down em').html(data.down);
                a.attr('data-original-title');
                a.attr('data-original-title', '您已' + title).tooltip('show').attr('data-original-title', title);
            },
            error: function (XMLHttpRequest, textStatus) {
                if(XMLHttpRequest.status == 302){
                    $('#modal').modal({ remote: XMLHttpRequest.getResponseHeader('X-Redirect')});
                }
                if(XMLHttpRequest.status == 403){
                    $.modalLogin();
                }
                this.abort();

            }
        });
        return false;
    });
    //详细页收藏
    $('.favourites a').on('click', function() {
        var a = $(this);
        var i = a.find('i');
        var em = a.find('em');
        var params = a.data('params');
        $.ajax({
            url: a.attr('href'),
            type:'post',
            data:params,
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    i.attr('class', 'fa fa-star');
                    a.attr('data-original-title', '您已收藏').tooltip('show').attr('data-original-title', '取消收藏');
                } else {
                    i.attr('class', 'fa fa-star-o');
                    a.attr('data-original-title', '您已取消收藏').tooltip('show').attr('data-original-title', '收藏');
                }
                em.html(data.count);
            },
            error: function (XMLHttpRequest, textStatus) {
                if(XMLHttpRequest.status == 302){
                    $('#modal').modal({ remote: XMLHttpRequest.getResponseHeader('X-Redirect')});
                }
                if(XMLHttpRequest.status == 403){
                    $.modalLogin();
                }
                this.abort();
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
    // 签到
    $(".btn-registration").click(function(){
        var button = $(this);
        var url = button.attr('href');
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(html){
                button.html("<i class=\"fa fa-calendar-check-o\"></i> 今日已签到<br />已连续" + html.days + "天").removeClass('btn-registration').addClass('disabled');
            },
            error: function (XMLHttpRequest, textStatus) {
                if(XMLHttpRequest.status == 302){
                    $('#modal').modal({ remote: XMLHttpRequest.getResponseHeader('X-Redirect')});
                }
                if(XMLHttpRequest.status == 403){
                    $.modalLogin();
                }
                this.abort();
            }
        });
        return false;
    });
});

jQuery.extend({
    modalLoad: function(url, data, callback) {
        $('#commonModal .modal-body').load(url, data, callback);
        $('#commonModal').modal();
    },
    modalLogin: function() {
        $('#commonModal .modal-title').text('需要登录');
        $('#commonModal .modal-body').load(SITE_URL + '/site/login');
        $('#commonModal').modal();
    },
    modalAlert: function(content) {
        $('#commonModal .modal-title').text('友情提示');
        $('#commonModal .modal-body').html('<p>' + content + '</p>');
        $('#commonModal .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">确定</button>');
        $('#modal').modal();
    },
    modalConfirm: function(object) {
        $('#modal .modal-title').text('确认');
        $('#modal .modal-body').html('<p>' + object.attr('data-confirm') + '</p>');
        $('#modal .modal-footer').html('<a class="btn btn-primary" href="' + object.attr('href') + '" data-method="post">确定</a><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>');
        $('#commonModal').modal();
    },
    modalPrompt: function() {
    }
});

window.alert = $.modalAlert;
$("[data-confirm]").click(function() {
    $.modalConfirm($(this));
    return false;
});
$(".modal").on("hidden.bs.modal", function() {
    $(this).removeData("bs.modal");
});