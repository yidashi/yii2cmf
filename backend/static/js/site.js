/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    if (xhr.statusText != 'abort') {
        notify.error(xhr.responseText);
    }
});
$.extend(yii, {
    clickableSelector: 'a:not([data-ajax]), button:not([data-ajax]), input[type="submit"]:not([data-ajax]), input[type="button"]:not([data-ajax]), input[type="reset"]:not([data-ajax]), input[type="image"]:not([data-ajax])',
    confirm: function (message, ok, cancel) {
        $.modal.confirm(message, ok, cancel);
    }
});
$.extend({
    modal: {
        alert: function (message, type) {
            if (type == undefined) {
                type = 0;
            }
            layer.alert(message, {icon: type, title:"提示"});
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