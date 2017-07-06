/**
 * Created by yidashi on 16/7/28.
 */
$.extend($.modal, {
    login: function () {
        $('#modal-login').modal('show');
    }
});
$.extend(yii, {
    clickableSelector: 'a[data-ajax!=1], button, input[type="submit"], input[type="button"], input[type="reset"], ' +
    'input[type="image"]',
    confirm: function (message, ok, cancel) {
        $.modal.confirm(message, ok, cancel);
    }
});
var ajaxLink = function (options) {
    options = $.extend({
        method:$(this).data('method') || 'get',
        action:$(this).data('action') || $(this).attr('href'),
        refreshPjaxContainer: $(this).data('refresh-pjax-container') || null,
        refresh: $(this).data('refresh') || false,
        callback: $(this).data('callback') || null,
        confirm: $(this).data('confirm') || null,
        data: $(this).data('params') || {}
    }, options);
    var fn = function () {
        $.modal.loading();
        $.ajax({
            url: options.action,
            method: options.method,
            data: options.data,
            dataType: 'json',
            success: function (res) {
                if (res.status != undefined && res.status == 0) {
                    $.modal.error(res.message || '操作失败');
                    return;
                }
                if (!res.message) {
                    res.message = '操作成功';
                }
                $.modal.notify(res.message, 'success', function () {
                    if (options.refreshPjaxContainer) {
                        $.pjax.reload({container:'#' + options.refreshPjaxContainer, timeout: 0});
                    }
                    if (res.redirect) {
                        location.href = res.redirect;
                    } else {
                        if (options.refresh) {
                            location.reload();
                        }
                        if (options.callback) {
                            if ($.isFunction(options.callback)) {
                                options.callback(res);
                            } else if (typeof options.callback == 'string') {
                                eval(options.callback);
                            }
                        }
                    }
                });
            },
            complete: function () {
                $.modal.unloading();
            }
        });
    }
    if (options.confirm != null) {
        $.modal.confirm(options.confirm, function () {
            fn();
        });
    } else {
        fn();
    }
    return false;
}
var ajaxSubmit = function (options) {
    var $form = $(this);
    options = $.extend({
        method: $form.attr('method'),
        action: $form.attr('action'),
        refreshPjaxContainer: $form.data('refresh-pjax-container') || null,
        refresh: $form.data('refresh') || false,
        callback: $form.data('callback') || null,
        confirm: $form.data('confirm') || null
    }, options);
    var method = options.method,
        action = options.action,
        refreshPjaxContainer = options.refreshPjaxContainer,
        refresh = options.refresh,
        callback = options.callback;
    var fn = function () {
        $.modal.loading();
        $.ajax({
            url: action,
            method: method,
            data: $form.serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status != undefined && res.status == 0) {
                    $.modal.error(res.message || '操作失败');
                    return;
                }
                if (!res.message) {
                    res.message = '操作成功';
                }
                $.modal.notify(res.message, 'success', function () {
                    $form.trigger('reset');
                    if (refreshPjaxContainer) {
                        $.pjax.reload({container:'#' + refreshPjaxContainer, timeout: 0});
                    }
                    if (refresh) {
                        location.reload();
                    }
                    if (callback) {
                        if ($.isFunction(callback)) {
                            callback(res);
                        } else if (typeof callback == 'string') {
                            eval(callback);
                        }
                    }
                });
            },
            complete: function () {
                $.modal.unloading();
            }
        });
    }
    if (options.confirm != null) {
        $.modal.confirm(options.confirm, function () {
            fn();
        });
    } else {
        fn();
    }
    return false;
}
$(function(){
    $("[data-toggle=tooltip]").tooltip({container: 'body'});
    $('.modal-dialog').drags({handle:".modal-header"});
    $(document).on('click', 'a[data-ajax=1]', function () {
        return ajaxLink.call(this);
    });
    $(document).on('beforeSubmit', 'form[data-ajax=1]', function () {
        return ajaxSubmit.call(this);
    });
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
