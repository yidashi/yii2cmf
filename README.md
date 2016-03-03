###yii2 demo

> 一个demo而已


自己本地部署方法:（需要有redis 127.0.0.1:6379)

```
php yii migrate  // 导入demo初始化数据
// 如果需要采集文章
QUEUE=* php yii queue/run &
php yii article/run tiejiong 
```

前台地址: `/frontend/web/index.php`

后台地址: `/backend/web/index.php` demo 帐号`hehe` 密码`123456`

demo地址 `www.51siyuan.cn`

demo后台地址: `hehe.51siyuan.cn`  帐号密码跟本地部署一样