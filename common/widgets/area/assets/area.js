function getArea(id)
{
    var ele = $(event.target);
    var url = SITE_URL + '/area/children?id=' + id;
    $.get(url, function(res){
        var html = '<option value>请选择</option>';
        ele.next('select').next('select').html(html);
        for (i in res) {
            html += '<option value="'+i+'">'+res[i]+'</option>';
        }
        ele.next('select').html(html);
    });
}