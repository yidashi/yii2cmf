/**
 * Created by yidashi on 16/7/28.
 */
$(document).ajaxError(function(event,xhr,options,exc){
    if (xhr.statusText != 'abort') {
        notify.error(xhr.responseText);
    }
});