$.fn.getArea = function(options)
{
    this.on('change', function(){
        var id = $(this).val();
        var e = arguments.callee.caller.arguments[0] || window.event;
        var ele = $(e.target);
        var joinMark = options.url.indexOf('?') > -1 ? '&' : '?';
        var url = options.url + joinMark + 'id=' + id;
        $.get(url, function(res){
            var html = '<option value>请选择</option>';
            ele.next('select').next('select').html(html);
            for (i in res) {
                html += '<option value="'+i+'">'+res[i]+'</option>';
            }
            ele.next('select').html(html);
        });
    })
}