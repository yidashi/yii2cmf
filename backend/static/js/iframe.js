var num=0,oUl=$("#min_title_list"),hide_nav=$("#tab-nav");

/*获取顶部选项卡总长度*/
function tabNavallwidth(){
    var taballwidth=0,
        $tabNav = hide_nav.find(".acrossTab"),
        $tabNavWp = hide_nav.find(".tab-nav-wp"),
        $tabNavitem = hide_nav.find(".acrossTab li"),
        $tabNavmore =hide_nav.find(".tab-nav-more");
    if (!$tabNav[0]){return}
    $tabNavitem.each(function(index, element) {
        taballwidth += Number(parseFloat($(this).width()+60))
    });
    // $tabNav.width(taballwidth+25);
    var w = $tabNavWp.width();
    if(taballwidth+25>w){
        $tabNavmore.show()}
    else{
        $tabNavmore.hide();
        $tabNav.css({left:0})
    }
}

/*菜单导航*/
function admin_tab(obj){
    var bStop = false,
        bStopIndex = 0,
        href = $(obj).attr('href'),
        title = $(obj).attr("title"),
        topWindow = $(window.parent.document),
        show_navLi = topWindow.find("#min_title_list li"),
        iframe_box = topWindow.find("#iframe_box");

    if(title==""){
        alert("title属性不能为空");
        return false;
    }
    show_navLi.each(function() {
        if($(this).find('span').attr("data-href")==href){
            bStop=true;
            bStopIndex=show_navLi.index($(this));
            return false;
        }
    });
    if(!bStop){
        creatIframe(href,title);
        min_titleList();
    } else{
        show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
        iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",href);
    }
}

/*最新tab标题栏列表*/
function min_titleList(){
    var topWindow = $(window.parent.document),
        show_nav = topWindow.find("#min_title_list"),
        aLi = show_nav.find("li");
}

/*创建iframe*/
function creatIframe(href,titleName){
    var topWindow=$(window.parent.document),
        show_nav=topWindow.find('#min_title_list'),
        iframe_box=topWindow.find('#iframe_box'),
        iframeBox=iframe_box.find('.show_iframe');

    show_nav.find('li').removeClass("active");
    $li = $('<li>', {class:"active"});
    $li.append($('<span>', {"data-href": href}).text(titleName)).append('<i></i><em></em>');
    show_nav.append($li);
    $li.contextmenu({
        target:"#context-menu",
        onItem:onItem
    });
    iframeBox.hide();
    iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src='+href+'></iframe></div>');
    var showBox=iframe_box.find('.show_iframe:visible');
    showBox.find('iframe').load(function(){
        if (!titleName) {
            titleName = $('title', $(this.contentWindow.document)).text();
            var index = showBox.index();
            show_nav.find('li').eq(index).find('span').text(titleName);
        }
        tabNavallwidth();
        showBox.find('.loading').hide();
    });
}



/*关闭iframe*/
function removeIframe(index){
    var topWindow = $(window.parent.document),
        iframe = topWindow.find('#iframe_box .show_iframe'),
        tab = topWindow.find(".acrossTab li");
    tab.eq(index-1).addClass("active");
    tab.eq(index).remove();
    iframe.eq(index-1).show();
    iframe.eq(index).remove();
}
/*关闭其他iframe*/
function removeIframeOther(index){
    var topWindow = $(window.parent.document),
        iframe = topWindow.find('#iframe_box .show_iframe'),
        tab = topWindow.find(".acrossTab li");
    for(var i=0;i<tab.length;i++){
        if(tab.eq(i).find("i").length>0 && i!=index){
            tab.eq(i).remove();
            iframe.eq(i).remove();
        }
    }
    tab.eq(index).addClass("active");
    iframe.eq(index).show();
}

/*关闭所有iframe*/
function removeIframeAll(){
    var topWindow = $(window.parent.document),
        iframe = topWindow.find('#iframe_box .show_iframe'),
        tab = topWindow.find(".acrossTab li");
    for(var i=0;i<tab.length;i++){
        if(tab.eq(i).find("i").length>0){
            tab.eq(i).remove();
            iframe.eq(i).remove();
        }
    }
}

function onItem(context, e)
{
    var aIndex = $(e.target).parent('li').index();
    var iframeIndex = $(context).index();
    if (aIndex == 0) {
        removeIframe(iframeIndex);
    }else if (aIndex == 1) {
        removeIframeOther(iframeIndex);
    }else if (aIndex == 2) {
        removeIframeAll();
    }
}
$(function(){
    /*选项卡导航*/
    $(".main-sidebar").on("click",".sidebar a[href!='#']", function(){
        admin_tab(this);
        return false;
    });
    $("a[target='_blank']").on("click", function(){
        if ($(this).data('not-iframe')) {
            return;
        }
        admin_tab(this);
        return false;
    });

    $(document).on("click","#min_title_list li",function(){
        var bStopIndex=$(this).index();
        var iframe_box=$("#iframe_box");
        $("#min_title_list li").removeClass("active").eq(bStopIndex).addClass("active");
        iframe_box.find(".show_iframe").hide().eq(bStopIndex).show();
    });
    $(document).on("click","#min_title_list li i",function(){
        var aCloseIndex=$(this).parents("li").index();
        $(this).parent().remove();
        $('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();
        num==0?num=0:num--;
        tabNavallwidth();
    });
    $(document).on("dblclick","#min_title_list li",function(){
        var aCloseIndex=$(this).index();
        var iframe_box=$("#iframe_box");
        if(aCloseIndex>0){
            $(this).remove();
            $('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();
            num==0?num=0:num--;
            $("#min_title_list li").removeClass("active").eq(aCloseIndex-1).addClass("active");
            iframe_box.find(".show_iframe").hide().eq(aCloseIndex-1).show();
            tabNavallwidth();
        }else{
            return false;
        }
    });
    tabNavallwidth();

    $('#js-tabNav-next').click(function(){
        num==oUl.find('li').length-1?num=oUl.find('li').length-1:num++;
        toNavPos();
    });
    $('#js-tabNav-prev').click(function(){
        num==0?num=0:num--;
        toNavPos();
    });

    function toNavPos(){
        oUl.stop().animate({'left':-num*100},100);
    }
    $('.acrossTab li').contextmenu({
        target:"#context-menu",
        onItem:onItem
    });
    /*var openedIframe = $.cookie('iframe') ? JSON.parse($.cookie('iframe')) : [];
     $.removeCookie('iframe');
     for (var i=0;i<openedIframe.length;i++) {
     creatIframe(openedIframe[i].href, openedIframe[i].title);
     }

     window.onbeforeunload = function(event) {
     var openedIframe = [];
     $('#min_title_list li span').each(function (ele, index) {
     openedIframe.push({title:$(ele).text(), href:$(ele).data('href')});
     $.cookie('iframe', JSON.stringify(openedIframe));
     })
     }*/
});
