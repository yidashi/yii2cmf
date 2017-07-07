//window.tlsj && window.tlsj.invokeDanmuSwitch && window.tlsj.invokeDanmuSwitch();
window.turn_dm = function(state, _tag){
    if(window._re){
        _tag ? Zepto('#dm-switch').css('display', 'none') : Zepto('#dm-switch').css('display', 'block');
        switch(state){
            case 'on':
                window._re._open();
                break;
            case 'off':
                window._re._close();
                break;
            case 'pause':
                window._re._pause();
                break;
            case 'start':
                window._re._start();
                break;
            default:
                console.log('arguments error');
        }
    }else{
        if(window.localStorage){
            if(state === 'on'){
                localStorage.dmState = 'on';
            }else if(state === 'off'){
                localStorage.dmState = 'off';
            }
        }
    }
}

var DMRE = function(mgr, is_full_control){
    this.manager = mgr;
    this.DISPLAY_TIME = 1500;
    this.ANIM_TIME = 600;
    this.FADE_OUT_TIME = 300; // fade-out的速度
    this.itemMargin = 10; // 下边距
    this.timer = null;
    this.itemOpacity = 0;
    this.is_full_control = is_full_control;

    this.dmItemClass = '.dm-item';
    this._init();

    this.PIVOT_FOR_START_GETTING_NEW_DMS = 4;
}

DMRE.prototype._getUrlParam = function(name){
    var _reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)');
    var _target = window.location.search.substr(1).match(_reg);
    // if(_target != null) return unescape(_target[2]);
    if(_target != null) return true;
    return false;
}

DMRE.prototype._init = function(){
    var that = this;
    this.dmWrap = Zepto('#dm');
    this.dmWrapHeight = Zepto('#dm').height();
    this.dmSwitch = Zepto('#dm-switch');
    this.dmSwitchIcon = Zepto('#dm-switch .dm-switch-icon');
    this._ua = window.navigator.userAgent.toLowerCase();
    if(!/webkit/i.test(this._ua)){
        Zepto(this.dmSwitch).css('display', 'none');
        Zepto(this.dmWrap).css('display', 'none');
        //alert('弹幕暂不支持此终端');
        return;
    }
    this._isDown = this._getUrlParam('down');
    Zepto(this.dmWrap).empty();
    typeof this.is_full_control == 'boolean' && this.is_full_control ? Zepto(this.dmSwitch).css('display', 'none') : Zepto(this.dmSwitch).css('display', 'block');
    if(window.localStorage && !localStorage.dmState){
        localStorage.dmState = 'on'; // 初始化弹幕状态，默认打开，关闭为off
        this.manager.emit('dm_on');
    }
    Zepto(this.dmSwitch).bind('click', function(){
        if(localStorage.dmState === 'on'){
            that._close();
            tips('弹幕已关闭');
        }else{
            tips('弹幕已开启');
            that._open();
        }
    });
    // if(/android/i.test(this._ua)){
        // this.itemOpacity = 1;
        // if(localStorage.dmState === 'on'){
            // Zepto(this.dmSwitchIcon).css('background-position', '-20px 0');
        // }
    // }else{
        if(localStorage.dmState === 'on'){
            Zepto(this.dmSwitchIcon).addClass('open');
        }
    // }
    if(localStorage.dmState === 'off'){
        if(Math.floor(Math.random()*11) > 8){
            var t_html = '<div class="dm-item" style="top: ' + this.dmWrapHeight + 'px; opacity: ' + this.itemOpacity + '"><div class="avatar"><img src="http://qzapp.qlogo.cn/qzapp/100560706/D18F2CCE0413E7AA5C559BBC0C31AF7F/30"></div><p class="txt">鹿棣说，开启弹幕更加有趣！</p></div>';
        }
        Zepto(this.dmWrap).html(t_html);
        var tip_item = Zepto(this.dmWrap).find(this.dmItemClass).first();
        Zepto(tip_item).animate({
            'opacity': '1',
            '-webkit-transform': 'translateY(-92px)'
        }, that.ANIM_TIME, 'ease-out', function(){
            window.setTimeout(function(){
                Zepto(tip_item).animate({
                    'opacity': '0',
                    '-webkit-transform': 'translateY(-160px)'
                }, that.ANIM_TIME, 'ease-out', function(){
                    Zepto(tip_item).remove();
                });
            }, that.DISPLAY_TIME);
        });
    }
}

DMRE.prototype.log = function(text){
    jlog('[DMRE] ' + text);
}

DMRE.prototype._cutStr = function(str, len){
    var str_length = 0;
    var str_len = 0;
    str_cut = new String();
    str_len = str.length;
    for(var i = 0; i < str_len; i++){
        a = str.charAt(i);
        str_length++;
        if(escape(a).length > 4){
            str_length++;
        }
        str_cut = str_cut.concat(a);
        if(str_length >= len){
            str_cut = str_cut.concat("...");
            return str_cut;
        }
    }
    if(str_length < len){
        return str;
    }
}

DMRE.prototype._getDM = function(){
    var obj = this.manager.readSync();
    if(!obj){
        this.log('get_dm, get null value');
        return null;
    }
    var dm = obj.dm;
    if(!dm){
        this.log('get_dm, dm is null');
        return null;
    }
    // 如果队列中的dm数量少于阈值,通知this.manager开始获取下一批数据
    if(obj.len && obj.len < this.PIVOT_FOR_START_GETTING_NEW_DMS){
        this.log('get_dm, EVENT --> no_more_data');
        this.manager.emit('no_more_data');
    }
    return dm;
}

DMRE.prototype._cutStr = function(str, len){
    var str_length = 0;
    var str_len = 0;
    str_cut = new String();
    str_len = str.length;
    for(var i = 0; i < str_len; i++){
        a = str.charAt(i);
        str_length++;
        if(escape(a).length > 4){
            str_length++;
        }
        str_cut = str_cut.concat(a);
        if(str_length >= len){
            str_cut = str_cut.concat("...");
            return str_cut;
        }
    }
    if(str_length < len){
        return str;
    }
}

DMRE.prototype._renderDM = function(dm){
    if(!dm){
        return null;
    }
    var html = [];
    if(dm.type && dm.type == 'realtime'){ //是否为实时
        html.push('<div onclick=\'ga("send", "event", "dm", "click", "dm-item")\' class="dm-item new" style="top: ' + this.dmWrapHeight + 'px; opacity: ' + this.itemOpacity + '">');
    }else{
        html.push('<a data-id="'+dm.id+'" data-nickname="'+dm.nickname+'" class="dm-item" style="top: ' + this.dmWrapHeight + 'px; opacity: ' + this.itemOpacity + '" tapmode="">');
    }
    /*if(!this._isDown){
        html.push('<a class="dm-wrap" href="http://news.jiecao.fm/art_cmt.htm?id=' + dm.id + '&amp;uid1=' + (dm.member_id || "") + '&amp;nickname=' + encodeURIComponent(dm.nickname) + '&amp;cmt_id=' + dm.id + '">');
    }*/
    if(dm.isRe){ //是否有@
        html.push('<div class="avatar"><img src="' + dm.avatar + '" cc-username="'+ dm.nickname +'"><span>@</span><img src="' + dm.re_avatar + '" cc-username="'+ dm.re_nickname +'"></div>');
    }else{
        html.push('<div class="avatar"><img src="' + dm.avatar + '" cc-username="'+ dm.nickname +'"></div>');
    }
    html.push('<p class="txt">' + this._cutStr(dm.content, 80) + '</p>');
    /*if(!this._isDown){
        html.push('</a>');
    }*/
    html.push('</a>');
    return html.join('');
}

DMRE.prototype._load = function(){
    var _html = this._renderDM(this._getDM());
    if(_html != null){
        return _html;
    }else{
        return null;
    }
}

DMRE.prototype._start = function(){
    if(localStorage.dmState === 'off'){
        return;
    }
    var that = this;
    var _html = this._load();
    if(_html != null){
        Zepto(this.dmWrap).append(_html);
        this._anmite(false);
    }else{
        this._anmite(true);
    }
    this.timer = window.setTimeout(function(){
        that._start();
    }, that.DISPLAY_TIME);
    // if(/android/i.test(this._ua)){
        // Zepto(this.dmSwitchIcon).css('background-position', '-20px 0');
    // }else{
        Zepto(this.dmSwitchIcon).addClass('open');
    // }
}

DMRE.prototype._pause = function(){
    clearTimeout(this.timer);
    // if(/android/i.test(this._ua)){
        // Zepto(this.dmSwitchIcon).css('background-position', '0 0');
    // }else{
        Zepto(this.dmSwitchIcon).removeClass('open');
    // }
}

DMRE.prototype._close = function(){
    clearTimeout(this.timer);
    var dmWrap = Zepto(this.dmWrap);
    dmWrap.animate({ 'opacity': 0 }, this.ANIM_TIME, 'ease-out', function(){
        dmWrap[0].style.display="none";
    });
    
    // if(/android/i.test(this._ua)){
        // Zepto(this.dmSwitchIcon).css('background-position', '0 0');
    // }else{
        Zepto(this.dmSwitchIcon).removeClass('open');
    // }
    localStorage.dmState = 'off';
    this.manager.emit('dm_off');
}

DMRE.prototype._open = function(){
    clearTimeout(this.timer);
    var that = this,
        dmWrap = Zepto(this.dmWrap);
    dmWrap.animate({ 'opacity': 1}, this.ANIM_TIME, 'ease-out', function(){
        dmWrap[0].style.display='';
        that._start();
    });
    
    // if(/android/i.test(this._ua)){
        // Zepto(this.dmSwitchIcon).css('background-position', '-20px 0');
    // }else{
        Zepto(this.dmSwitchIcon).addClass('open');
    // }
    localStorage.dmState = 'on';
    this.manager.emit('dm_on');
}

DMRE.prototype._getTranslateY = function(item){
    return parseInt(Zepto(item).css('-webkit-transform').match(/\-?[0-9]+/g)[0]);
}

DMRE.prototype._anmite = function(isEnd){
    var that = this;
    var dmItems = Zepto(this.dmWrap).find(this.dmItemClass);
    var newItemHeight = Zepto(dmItems).last().height();
    var oldItemHeight = Zepto(dmItems).first().height();
    if(isEnd){
        Zepto(dmItems).each(function(index, item){
            if(that.dmWrapHeight + that._getTranslateY(this) <= oldItemHeight){
                Zepto(this).animate({
                    'opacity': '0'
                }, that.FADE_OUT_TIME, 'ease-out', function(){
                    Zepto(this).remove();
                   // if(Zepto(dmItems).size() - 1 == 0){
                   //     clearTimeout(that.timer);
                   //     console.log('clearTimeout');
                   // }
                });
            }else{
                Zepto(this).animate({
                    '-webkit-transform': 'translateY(' + (that._getTranslateY(this) - oldItemHeight - that.itemMargin) + 'px)'
                }, that.ANIM_TIME, 'ease-out');
            }
        });
    }else{
        Zepto(dmItems).each(function(index, item){
            if(index == Zepto(dmItems).size() - 1){
                Zepto(this).animate({
                    'opacity': '1',
                    '-webkit-transform': 'translateY(' + (-newItemHeight-that.itemMargin) + 'px)'
                }, that.ANIM_TIME, 'ease-out');
            }else{
                if(that.dmWrapHeight + that._getTranslateY(this) <= newItemHeight){
                    Zepto(this).animate({
                        'opacity': '0'
                    }, that.FADE_OUT_TIME, 'ease-out', function(){
                        Zepto(this).remove();
                    });
                }else{
                    Zepto(this).animate({
                        '-webkit-transform': 'translateY(' + (that._getTranslateY(this) - newItemHeight - that.itemMargin) + 'px)'
                    }, that.ANIM_TIME, 'ease-out');
                }
            }
        });
    }
}

jlog('DMRE loaded');