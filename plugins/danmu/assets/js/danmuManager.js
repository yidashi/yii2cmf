var viewport_height = $(window).height();
var webpage_height = $(document).height();
var current_postion = $(document).scrollTop();
var page = 1;
/**
 * 弹幕数据生成器
 * @param danmuListUrl 弹幕数据获取的url
 * @param art_id 弹幕对应的文章id
 */
var DanmuManager = function(opt) {
  this.q = []; // store danmu collection
  this.danmu_list_url = opt.danmu_list_url;
  this.entity_id = opt.entity_id;  //文章ID
  this.entity = opt.entity;  //文章ID
  this.pos_current = 0; //进度
  this.pos_last_time = 0;  //上次请求的文章进度
  this.fetch_size = opt.fetch_size || 20; //ajax获取弹幕时的数量
  this.is_fetching = false;  //是否正在ajax获取
  this.pos_sections = [];  //文章进度所属的部分
  this.has_next = true;  //是否存在下一页
  this.has_next_pos_section = -1;  //是否存在下一页的数据点
  this.last_dm_ids = {};
};

DanmuManager.prototype.push = function(dm) {
  if(!dm){
    return this.log('push, NULL data pushed');
  }
  dm.avatar = dm.avatar || '../image/default/avatar.png';
  dm.type = 'realtime';
  this.q.unshift(dm);
  this.log('EVENT push_fired EMITTED:' + DM_ToString.call(dm));
};

/**
 * 取出一条需要显示的数据
 */
DanmuManager.prototype.read = function(cb) {
  //始终返回队列顶部数据
  var dm = this.q.shift();
  //检查队列长度以判断是否需要拉取新的弹幕列表
  var len = this.q.length;

  //如果队列有数据
  if(len == 0){
    //如果队列没有数据了
    this.log('read, dm=null, len=' + this.len);
    this.get_list();
    return cb(null, len);
  }

  if(dm && dm.id){
    this.log('read, dm=' + dm.id + ', dm.avatar=' + dm.avatar);
    dm.avatar = this.optimizeImg(dm.avatar);
    return cb(dm, len);
  } else {
    return cb(null, len);
  }
}

DanmuManager.prototype.optimizeImg = function(url){
  if(url && url.search('qzapp.qlogo.cn/') > 0){ // QQ avatar
    url = url.replace(/\/100$/,'\/30');
  }
  if(url && url.search('sinaimg.cn') > 0){ // Weibo avatar
    url = url.replace(/\/50\//, '\/30\/');
  }
  return url;
}

/**
 * 取出一条需要显示的数据
 */
DanmuManager.prototype.readSync = function() {
  //始终返回队列顶部数据
  var dm = this.q.shift();
  //检查队列长度以判断是否需要拉取新的弹幕列表
  var len = this.q.length;

  //如果队列有数据
  if(dm){
    dm.avatar = this.optimizeImg(dm.avatar);
    dm.content = this.filterContent(dm.content);
    this.log('read, dm=' + dm.id + ', dm.avatar=' + dm.avatar);
    return {'dm': dm, 'len': len};
  }

  //如果队列里没有数据
  this.log('read, dm=null, len=' + this.len);
  this.get_list();
  return {'dm': null, 'len': 0};
}

var kw = [/兼职/,/淘宝/,/扣扣/,/结算/,/结算/,/加Q/,/天猫/,/傔职/,/掏宝/,/在线客服/,/诚聘/,/贝兼/,/间职/,/空余时间/,/日結/,/加q/,/蒹职/,/上班族/];
DanmuManager.prototype.filterContent = function(str){
  for(var len = kw.length, i=0; i< len; i++){
    if(str.match(kw[i])){
      return "笑Cry！";
      break;
    }
  }
  return str;
};

DanmuManager.prototype.get_current_pos = function(){
  var _tmp = parseInt($(document).scrollTop() / $(document).height() * 100, 10);
  if(_tmp < 0){
    _tmp = 0;
  }
  return _tmp;
};

DanmuManager.prototype.get_pos_section = function(_tmp_pos){
  _tmp_pos = _tmp_pos || this.get_current_pos();
  var _pos = 0;
  for(var i=0, len=this.pos_sections.length; i < len; i++){
    if(_tmp_pos >= this.pos_sections[i]){
      _pos++;
    } else {
      break;
    }
  }
  this.log('get_pos_section, pos_current=' + _tmp_pos + ', _pos=' + _pos);
  return _pos < 1 ? 1 : _pos;
};

DanmuManager.prototype.prepare_pos_section = function(pos_arr){
  // 不重复设置值
  if(this.pos_sections && this.pos_sections.length > 0){
    return;
  }
  if(pos_arr && pos_arr.length > 0){
    this.pos_sections = pos_arr;
  } else {
    this.pos_sections = [0, 100];  //如果服务器端没有返回，设置默认值
  }
};

/**
 * 向服务器端获取列表数据
 */
DanmuManager.prototype.get_list = function() {
  // 如果ajax正在执行，直接跳过
  if(this.is_fetching){
    return this.log('get_list, is_fetching=true');
  }
  // 如果在当期位置的分区上没有下一页了，直接跳过
  var _current_section = this.get_pos_section();
  if(_current_section == this.has_next_pos_section){
    if(!this.has_next){
      return this.log('get_list, no more data on section=' + _current_section);
    }
  } else {
    //如果已经更换了当前的区域
    this.log('get_list, changed from section=' + this.has_next_pos_section + ' to section=' + _current_section);
    this.has_next = true;
  }
  this.is_fetching = true;
  // 设置位置
  this.pos_current = this.get_current_pos();
  this.log('get_list, pos_current=' + this.pos_current);
  this.log('get_list, ' + this.danmu_list_url);
  var that = this;
  if(!this.danmu_list_url){
    throw Error('this.danmu_list_url is null');
    return;
  }
  var ts = (new Date).valueOf();
  this.fetch_latest_ts = ts;
  // 获取当前进度的最后一次获取的弹幕ID
  var _last_dm_id = this.last_dm_ids[_current_section + ''] || 0;
  var post_data = {
      entity_id : that.entity_id,
      entity : that.entity,
      bpos: that.pos_last_time,
      epos: that.pos_current,
      pagesize: that.fetch_size,
      last_id: _last_dm_id,
      time: ts,
      page:page
  };
  this.log('---start ajax---');
  jlog(post_data);
  $.ajax({
    url : that.danmu_list_url,
    dataType : 'json',
    data: post_data,
    type: 'post',
    success:function(data) {
      that.is_fetching = false;
      if(!data){
        return that.log('get_list, ajax, null result');
      }
      if(_current_section != that.get_pos_section()){
        return that.log('give up, cause pos_section has been changed');
      }
      page++;
      var dm_list = that.transform(data, _current_section);
      that.append_data(dm_list);
      that.log('get_list, has_next=' + data.hasNext);
      that.prepare_pos_section(data.posSection);
      that.has_next = data.hasNext;
      that.has_next_pos_section = _current_section;
    },
    error: function(err){
      that.log('get_list err: ' + err);
      jlog(err);
      that.append_data(null);
      that.is_fetching = false;
      that.has_next = false;
      that.has_next_pos_section = _current_section;
    }
  });
  // Set pos_last_time = pos_current;
  that.pos_last_time = that.pos_current;
};

DanmuManager.prototype.transform = function(data, curr_section){
  var arr = data.list || [];
  if(arr){
    var dm = arr[arr.length - 1];
    if(dm){
      this.last_dm_ids[curr_section + ''] = dm.id;
    }
  }
  return arr;
};

DanmuManager.prototype.append_data = function(data) {
  this.log('append_data, data.length=' + (!data ? 'null' : data.length));
  this.is_fetching = false;
  if(data && data.length > 0){
    this.q = this.q.concat(data);
    this.log('append_data, add new, q.length=' + this.q.length);
  } else {
    this.log('append_data, empty');
    this.stop_fetch = true;
  }
};

DanmuManager.prototype.log = function(text) {
  jlog('[DanmuManager] ' + text);
};