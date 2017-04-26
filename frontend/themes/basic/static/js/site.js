/**
 * Created by yidashi on 16/7/28.
 */
$.extend($.modal, {
    login: function () {
        $('#modal-login').modal('show');
    }
});
$(function(){
    $("[data-toggle=tooltip]").tooltip({container: 'body'});
    $(".content-wrapper").css("min-height", $(window).height()-$(".footer").outerHeight()-60);
    //投票
    $(document).on('click', '.vote a', function() {
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
    $(document).on('click', '.favourites a', function() {
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
    $(document).on("click", ".reply-btn", function(){
        if ($(this).closest('.media-body').children('.reply-form:visible').size() > 0) {
            $('.reply-form').addClass('hidden');
        } else {
            $('.reply-form').removeClass('hidden');
            $('.reply-form').appendTo($(this).closest('.media-body'));
            $('.reply-form').find('.parent_id').val($(this).parents('li').attr('data-key'));
            if($(this).parents('div.media').length > 0) {
                $('.reply-form').find('textarea').val('@' + $(this).closest('.media-body').find('[rel=author]').first().html() + ' ');
            } else {
                $('.reply-form').find('textarea').val('');
            }
        }
        return false;
    });
    // 签到
    $(document).on('click', ".btn-registration", function(){
        var button = $(this);
        var url = button.attr('href');
        var loading = $.modal.loading();
        $.ajax({
            url: url,
            dataType: 'json',
            method:'post',
            success: function(html){
                button.html("<i class=\"fa fa-calendar-check-o\"></i> 今日已签到<br />已连续" + html.days + "天").removeClass('btn-registration').addClass('disabled');
            },
            complete: function () {
                $.modal.close(loading);
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
$(document).ajaxError(function(event,xhr,options,exc){
    if(xhr.status == 302){
        $.modal.load(xhr.getResponseHeader('X-Redirect'));
    } else if(xhr.status == 403){
        $.modal.login();
    } else {
        var message = xhr.responseJSON ? xhr.responseJSON.message : '操作失败';
        $.modal.error(message);
    }
});
