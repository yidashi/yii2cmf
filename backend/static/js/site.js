/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    var message = xhr.responseJSON ? xhr.responseJSON.message : '操作失败';
    $.modal.error(message);
});
$(function () {
    $("a[target='_blank']").on('click', function () {
        if (parent != window) {
            parent.admin_tab(this);
            return false;
        }
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