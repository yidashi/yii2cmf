/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.3.3
 *
 * Extension to bootstrap datepicker to use noconflict approach
 * so that the plugin does not conflict with other jquery plugins
 * of similar name
 *
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * Year: 2015
 * For more Yii related demos visit http://demos.krajee.com
 */var initDPRemove=function(){},initDPAddon=function(){};!function(n){n.fn.kvDatepicker=n.fn.datepicker.noConflict(),initDPRemove=function(e,t){var i=n("#"+e),c=i.parent();c.find(".kv-date-remove").on("click.kvdatepicker",function(){t?c.find('input[type="text"]').each(function(){n(this).kvDatepicker("clearDates")}):c.kvDatepicker("clearDates")})},initDPAddon=function(e){var t=n("#"+e),i=t.parent();i.find(".input-group-addon:not(.kv-date-calendar):not(.kv-date-remove)").each(function(){var e=n(this);e.on("click.kvdatepicker",function(n){i.kvDatepicker("hide")})})}}(window.jQuery);