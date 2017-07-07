/**
 * DM.js
 * C.C. <fanweixiao@gmail.com>
 */

 __jlog_disabled = true;
 $('#dm').remove();
 // $('#dm-switch').remove();

function start_sio(entity, entity_id, dm_mgr, cb){
  console.log('-->');
  delete localStorage.debug;
  //localStorage.debug='*,-engine.io*';
  var opts = {
    reconnection: true,
    reconnectionAttempts: 5,
    reconnectionDelay: 5000,
    reconnectionDelayMax: 10000,
    //transports: ['websocket', 'polling'],
    query: 'entity_id=' + article_id + '&entity=' + entity
  };
  var socket = io.connect('ws://dm3.jiecao.fm/art', opts);
  window.__socket = socket;
  socket.on('status', function(data){
    jlog(data);
    dm_mgr.push(data);
  });
  socket.on('disconnect', function(){
    jlog('==> socket.io disconnect');
  });
  socket.on('connect', function(){
    console.log('==> socket.io connected');
  });
  socket.on('error', function(err){
    jlog('[EE] socket.io error: ' + err);
  });
  if(typeof(cb) !== 'undefined'){
    cb(socket);
  }
}

function start(entity, entity_id, list_url){
  // Get querystring from url
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  // Get article_id
/*  var article_id = getParameterByName('id');
  if(typeof(art_id) != 'undefined'){
    article_id = art_id
  }

  if(!article_id){
    jlog('can not find article id, set art_id=`public_room`');
    article_id = 'public_room';
  }
  jlog('art_id=' + article_id);*/

  var opt = {
     entity: entity,
     entity_id : entity_id,
     danmu_list_url : list_url
  };

  if(typeof(danmuListUrl) !== 'undefined'){
    opt.danmu_list_url = danmuListUrl
  }

  jQuery.extend(DanmuManager.prototype, jQuery.eventEmitter);
  window.dm_mgr = new DanmuManager(opt);

  dm_mgr.on('no_more_data', function(){
    dm_mgr.log('* EVENT::no_more_data');
    dm_mgr.get_list();
  });

  dm_mgr.on('dm_on', function(){
    if(typeof __socket == 'undefined'){
      // start_sio(article_id, dm_mgr);
      return;
    }
    if(__socket && !__socket.connected){
      __socket.connect();
    }
  });

  dm_mgr.on('dm_off', function(){
    if(typeof __socket != 'undefined' && __socket.connected){
      __socket.disconnect();
    }
  });

  /***************C.C. 2014-08-26******************/
  var __ts="";
  if(location.search.indexOf('turn_dm=') >= 0){
    __ts = getParameterByName('turn_dm');
    //turn_dm2(ts + (new Date).valueOf());
    if(__ts == 'on'){
      localStorage.dmState = 'on';
    } else {
      localStorage.dmState = 'off';
    }
  }
  /***************C.C. 2014-08-26******************/

  window._re = new DMRE(dm_mgr, __ts != "");

  /*----------------C.C. 2014-08-25 -------------- */
  if(__ts){
    if(__ts =='on'){
      localStorage.dmState = 'on';
      _re._start();
      // start_sio(article_id, dm_mgr);
    } else {
      localStorage.dmState = 'off';
      _re._close();
    }
    return;
  }
  /*------------------------------------------------*/

  window._re._start();
  // start_sio(article_id, dm_mgr);
};

// for test
var DM = function(){
  this.nickname = '';
  this.content = '';
  this.avatar = '';
  this.type = 'polling';
};

var DM_ToString = DM.prototype.toString = function(){
  return 'nickname=' + this.nickname + ', content=' + this.content + ', avatar=' + this.avatar + ', type=' + this.type;
};


function initDm(entity, entity_id, list_url){
  setTimeout(function(){
    // $('body').prepend('<div id="dm-switch"><div class="dm-switch-icon"></div></div>');
    $('body').prepend('<div id="dm"></div>');
    start(entity, entity_id, list_url);
    //点击每个弹幕块
    // var inputField = api.require('inputField');
    $('#dm').on('click','.dm-item',function(){
      var that=this;
      to_comment_id=$(that).data('id');
      $('#chat').attr('placeholder','回复'+$(that).data('nickname')).focus();
      // inputField.becomeFirstResponder();
    });
  }, 1000);
};