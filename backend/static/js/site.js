/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    var message = xhr.responseJSON ? xhr.responseJSON.message : '操作失败';
    if (xhr.status == 403) {
        message = xhr.responseText;
    }
    $.modal.error(message);
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
    var ele = $(this);
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
                            options.callback(res);
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
                        callback(res);
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
$(function () {
    $(document).on('click', "a[target='_blank']", function () {
        if ($(this).attr('no-iframe')) {
            return true;
        }
        if (parent != window) {
            parent.admin_tab(this);
            return false;
        }
    });
    $(".fancybox").fancybox({
        prevEffect	: 'none',
        nextEffect	: 'none',
        helpers	: {
            title	: {
                type: 'float'
            },
            buttons	: {},
            thumbs	: {
                width	: 50,
                height	: 50
            }
        }
    });
    $('[data-toggle=popover]').popover();
    $('[data-toggle=tooltip]').tooltip();
    $('.modal-dialog').drags({handle:".modal-header"});
    $(document).on('click', 'a[data-ajax=1]', function () {
        return ajaxLink.call(this);
    });
    $(document).on('beforeSubmit', 'form[data-ajax=1]', function () {
        return ajaxSubmit.call(this);
    });
    var elems = Array.prototype.slice.call(document.querySelectorAll('[data-toggle=switcher]'));
    elems.forEach(function(html) {
        var disabled = !!$(html).data('switcher-disabled');
        var size = $(html).data('switcher-size') || 'small';
        var switchery = new Switchery(html,{ size: size, disabled:disabled, disabledOpacity:0.5 });
        $(html).data('switchery', switchery);
    });
})
String.prototype.addQueryParams = function(params) {
    var split = '?';
    if (this.indexOf('?') > -1) {
        split = '&';
    }

    var queryParams = '';
    for(var i in params) {
        queryParams += i + '=' + params[i] + '&';
    }
    queryParams = queryParams.substr(0, queryParams.length -1)
    return this + split + queryParams;
}