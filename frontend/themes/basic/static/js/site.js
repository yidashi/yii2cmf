/**
 * Created by yidashi on 16/7/28.
 */
$.extend(yii, {
    confirm: function (message, ok, cancel) {
        $.modal.confirm(message, ok, cancel);
    }
});
$.extend({
    modal: {
        alert: function (message, type, callback) {
            if (type == undefined) {
                type = 0;
            }
            layer.alert(message, {icon: type, title:"提示"}, function (index) {
                layer.close(index)
                if (callback) {
                    callback();
                }
            });
        },
        info: function (message) {
            this.alert(message, 0);
        },
        success: function (message) {
            this.alert(message, 1);
        },
        error: function (message) {
            this.alert(message, 2);
        },
        confirm: function (message, ok, cancel) {
            layer.confirm(message, {icon: 3, title:'提示'}, function(index){
                ok();
                layer.close(index);
            });
        },
        load: function (url, message, data) {
            var loading = layer.load();
            $.ajax({
                url: url,
                data:data,
                type: data ? 'post' : 'get',
                success: function (str) {
                    layer.close(loading);
                    index = layer.open({
                        type: 1,
                        title:message,
                        area:['900px'],
                        content: str,
                    });
                }
            });
        },
        login: function() {
            this.load(LOGIN_URL);
        },
        close: function (index) {
            if (index != undefined) {
                layer.close(index);
            } else {
                layer.closeAll();
            }
        }
    }
});
window.alert = $.modal.alert;
$(function () {
    $(document).off('click', "[data-remote-modal]").on('click', "[data-remote-modal]", function() {
        var url = $(this).data('remote-modal-url') || $(this).attr('href');
        var title = $(this).data('remote-modal-title') || $(this).text();
        var data = $(this).data('remote-modal-params') || {};
        $.modal.load(url, title, data);
        return false;
    });
})
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
            method:'post',
            success: function(html){
                button.html("<i class=\"fa fa-calendar-check-o\"></i> 今日已签到<br />已连续" + html.days + "天").removeClass('btn-registration').addClass('disabled');
            }
        });
        return false;
    });
    $(document).on('click', '.follow', function() {
        var a = $(this);
        var url = a.attr('href');
        $.ajax({
            url:url,
            method:'post',
            dataType: 'json',
            success:function(data) {
                if (a.hasClass('btn')) {
                    a.html('<i class="fa fa-check"></i> ' + data.message).addClass('disabled');
                } else {
                    a.replaceWith('<i class="fa fa-check"></i> ' + data.message);
                }
            }
        });
        return false;
    });
});
$('.view-content a').attr('target', '_blank');


$(document).ajaxError(function(event,XMLHttpRequest,options,exc){
    if(XMLHttpRequest.status == 302){
        $('#modal').modal({ remote: XMLHttpRequest.getResponseHeader('X-Redirect')});
    } else if(XMLHttpRequest.status == 403){
        $.modal.login();
    } else {
        alert(XMLHttpRequest.responseJSON.message);
    }
});
