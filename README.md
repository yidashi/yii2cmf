自己本地部署方法:

进入项目根目录

```
php init
mysql -uroot -proot -e 'create database yii;' //（root root分别是你本地的mysql用户和密码，别直接复制。。。创建yii库，默认名字是yii，如果你不想用这个名字或者用已有的数据库，需要修改common/config/main-local.php里相关的数据库配置）
php yii migrate  //导入demo初始化数据（如果导入失败，可以到console/migrations/里找init.sql直接导入）
// demo里的文章都是采集的，如果需要采集文章（linux环境，需要有redis）
QUEUE=* php yii queue/run &
php yii article/run tiejiong 
```


前台地址: `/frontend/web/index.php`

后台地址: `/backend/web/index.php` demo 帐号`hehe` 密码`111111`

demo地址 `www.51siyuan.cn`

demo后台地址: `hehe.51siyuan.cn`  帐号密码跟本地部署一样
