/**
 * Created by pc on 2016/10/21.
 */
$.extend({
    modal: {
        alert: function (message, type, callback) {
            if (type == undefined) {
                type = "info";
            }
            swal({
                title: message,
                type: type,
                showConfirmButton: true,
            },
            function(){
                if (callback) {
                    callback();
                }
            });
        },
        info: function (message) {
            swal(message);
        },
        success: function (message) {
            this.notify(message, 'success');
        },
        error: function (message) {
            this.notify(message, 'error');
        },
        notify: function (message, type, callback) {
            swal({
                title: message,
                type: type,
                timer: 1500,
                showConfirmButton: false,
                animation: false
            }, function () {
                if (callback) {
                    callback();
                }
                // 没callback时候不会关闭，应该是bug
                swal.close();
            });
        },
        confirm: function (message, ok, cancel) {
            swal({
                title: message,
                type: "warning",
                showCancelButton: true,
                cancelButtonText:"取消",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                closeOnConfirm: false,
                animation: false,
                showLoaderOnConfirm: true
            },
            function(){
                ok();
            });
        },
        loading:function () {
            $("<div>", {id:"loading-global", class:"loading-global"}).appendTo('body');
        },
        unloading:function () {
            $("#loading-global").remove();
        },
        close: function (index) {
            swal.close();
        }
    }
});
window.alert = $.modal.alert;