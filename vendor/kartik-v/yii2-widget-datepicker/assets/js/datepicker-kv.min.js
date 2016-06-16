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
 */var initDPRemove=function(){},initDPAddon=function(){};!function(n){"use strict";n.fn.kvDatepicker=n.fn.datepicker.noConflict(),initDPRemove=function(t,e){var i,c=n("#"+t),a=c.parent();a.find(".kv-date-remove").on("click.kvdatepicker",function(){e?a.find('input[type="text"]').each(function(){n(this).kvDatepicker("clearDates").trigger("change")}):(a.kvDatepicker("clearDates"),i=a.is("input")?a:a.find('input[type="text"]'),i.trigger("change"))})},initDPAddon=function(t){var e=n("#"+t),i=e.parent();i.find(".input-group-addon:not(.kv-date-calendar):not(.kv-date-remove)").each(function(){var t=n(this);t.on("click.kvdatepicker",function(){i.kvDatepicker("hide")})}),i.find(".input-group-addon.kv-date-calendar").on("click.kvdatepicker",function(){e.focus()})}}(window.jQuery);