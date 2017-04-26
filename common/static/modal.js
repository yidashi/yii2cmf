/**
 * Created by pc on 2016/10/21.
 */
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
            this.msg(message, 1);
        },
        error: function (message) {
            this.msg(message, 0);
        },
        confirm: function (message, ok, cancel) {
            layer.confirm(message, {icon: 3, title:'提示'}, function(index){
                ok();
                layer.close(index);
            });
        },
        msg: function (message, success) {
            layer.msg(message, {icon: success ? 1 : 2});
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
                        area:['700px'],
                        content: '<div class="container-fluid">' + str + '</div>',
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