/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    var message = xhr.responseJSON ? xhr.responseJSON.message : '操作失败';
    $.modal.error(message);
});
$(function () {
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
    $("a[target='_blank']").on('click', function () {
        if ($(this).attr('no-iframe')) {
            return true;
        }
        if (parent != window) {
            parent.admin_tab(this);
            return false;
        }
    });
    var elems = Array.prototype.slice.call(document.querySelectorAll('[data-toggle=switcher]'));
    elems.forEach(function(html) {
        var disabled = !!$(html).data('switcher-disabled');
        var size = $(html).data('switcher-size') || 'small';
        var switchery = new Switchery(html,{ size: size, disabled:disabled, disabledOpacity:0.5 });
        $(html).data('switchery', switchery);
    });
});
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