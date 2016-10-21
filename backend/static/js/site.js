/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    var message = xhr.responseJSON.message || '操作失败';
    $.modal.error(message);
});
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
        loading:function () {
            return layer.load();
        },
        load: function (url, message, data) {
            var loading = this.loading();
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