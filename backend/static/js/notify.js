$(function() {
    /**
     * ajax操作后返回的通知
     */
    var Notify = function() {

        var queue = [];
        var _this = this;

        var notifyWrapper;;

        var lock = false;

        //避免该wrapper被删除掉
        this.getNotifyWrapper = function()
        {
            if($("#notify-alert").length == 0)
            {
                this.notifyWrapper = $('<div id="notify-alert" ></div>').prependTo('.content');
            }

            return this.notifyWrapper;
        }

        this.msg = function(status,title) {
            if(status == true)
            {
                this.success(title);
            }
            else if(status == false)
            {
                this.error(title);
            }
        }

        this.success = function(title) {
            queue.push({
                type : 'success',
                title : title,
                icon : 'fa-check'
            });
            _this.proceedQueue();
        }

        this.error = function(title) {
            queue.push({
                type : 'danger',
                title : title,
                icon : 'fa-ban'
            });
            _this.proceedQueue();
        }

        this.proceedQueue = function() {
            if (queue.length == 0 || lock == true) {
                return;
            }

            lock = true;
            _this.getNotifyWrapper()
                .removeClass().removeAttr("style")
                .addClass(
                    'alert alert-dismissible flat alert-'
                    + queue[0].type)
                .html(
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa '
                    + queue[0].icon
                    + '"></i> '
                    + queue[0].title);
            queue.shift();
            setTimeout(_this.nextQueue,3000);
        }

        this.nextQueue = function(){
            _this.getNotifyWrapper().fadeToggle(function() {
                lock = false;
                _this.proceedQueue();
            });
        }

    };

    window.notify = new Notify();
});
