/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    var message = xhr.responseJSON ? xhr.responseJSON.message : '操作失败';
    $.modal.error(message);
});
$(function () {
    $(document).off('click', "[data-remote-modal]").on('click', "[data-remote-modal]", function() {
        var url = $(this).data('remote-modal-url') || $(this).attr('href');
        var title = $(this).data('remote-modal-title') || $(this).text();
        var data = $(this).data('remote-modal-params') || {};
        $.modal.load(url, title, data);
        return false;
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