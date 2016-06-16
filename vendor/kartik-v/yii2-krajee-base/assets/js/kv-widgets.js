/*!
 * @package    yii2-krajee-base
 * @subpackage yii2-widget-activeform
 * @author     Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright  Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version    1.8.5
 *
 * Common client validation file for all Krajee widgets.
 *
 * For more JQuery/Bootstrap plugins and demos visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
var kvInitPlugin, kvListenEvent, kvInitHtml5;
(function ($) {
    "use strict";
    /**
     * Krajee's selector string fetcher. Gets the selector from a jQuery object based on the following logic:
     * - if an `id` attribute if available the selector is returned based on the id attribute,
     * - else if a data attribute `kvId` exists the selector is returned based on this data attribute,
     * - else a unique data attribute `kvId` is generated and the selector is returned based on this data attribute.
     */
    $.fn.kvSelector = function () {
        var $node = $(this), id, sel = '', len = 1;
        if (!$node.length) {
            return '';
        }
        id = $node.attr('id');
        if (id) {
            return '#' + id;
        }
        id = $node.attr('data-kv-id');
        if (id) {
            return '[data-kv-id="' + id + '"]';
        }
        while (len) {
            id = 'kv-' + Math.round(new Date().getTime() + (Math.random() * 100));
            sel = '[data-kv-id="' + id + '"]';
            len = $(sel).length;
        }
        $node.attr('data-kv-id', id);
        return sel;
    };
    /**
     * Initialize a Krajee plugin
     * @param selector string, the plugin selector
     * @param callback function, the plugin initialization function
     */
    kvInitPlugin = function (selector, callback) {
        var $body = $(document.body);
        if ($body.length) {
            $body.on('load', selector, callback());
        } else {
            callback();
        }
    };
    /**
     * Listen to a Krajee plugin event
     * @param event string, the plugin event
     * @param selector string, the plugin selector
     * @param callback function, the plugin initialization function
     */
    kvListenEvent = function (event, selector, callback) {
        $(selector).on(event, callback);
    };
    /**
     * Initialize HTML5 Input Widgets
     * @param idCap string, the id of the caption element
     * @param idInp string, the id of the input element
     */
    kvInitHtml5 = function (idCap, idInp) {
        var $caption = $(idCap), $input = $(idInp);
        $(document).on('change', idCap, function () {
            $input.val(this.value);
        }).on('input change', idInp, function (e) {
            $caption.val(this.value);
            if (e.type === 'change') {
                $caption.trigger('change');
            }
        });
    };
})(window.jQuery);