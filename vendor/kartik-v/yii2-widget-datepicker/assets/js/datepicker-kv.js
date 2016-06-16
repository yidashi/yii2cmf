/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.3.9
 *
 * Extension to bootstrap datepicker to use noconflict approach
 * so that the plugin does not conflict with other jquery plugins
 * of similar name
 *
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * Year: 2015
 * For more Yii related demos visit http://demos.krajee.com
 */
var initDPRemove = function () {
}, initDPAddon = function () {
};
(function ($) {
    "use strict";
    $.fn.kvDatepicker = $.fn.datepicker.noConflict();
    initDPRemove = function (id, range) {
        var $id = $('#' + id), $el = $id.parent(), $input;
        $el.find('.kv-date-remove').on('click.kvdatepicker', function () {
            if (range) {
                $el.find('input[type="text"]').each(function () {
                    $(this).kvDatepicker('clearDates').trigger('change');
                });
            } else {
                $el.kvDatepicker('clearDates');
                $input = $el.is('input') ? $el : $el.find('input[type="text"]');
                $input.trigger('change');
            }
        });
    };
    initDPAddon = function (id) {
        var $id = $('#' + id), $el = $id.parent();
        $el.find('.input-group-addon:not(.kv-date-calendar):not(.kv-date-remove)').each(function () {
            var $addon = $(this);
            $addon.on('click.kvdatepicker', function () {
                $el.kvDatepicker('hide');
            });
        });
        $el.find('.input-group-addon.kv-date-calendar').on('click.kvdatepicker', function () {
            $id.focus();
        });
    };
})(window.jQuery);
