demo地址 `www.51siyuan.cn`

demo后台地址: `www.51siyuan.cn/admin`  帐号 `demo` 密码 `111111`

## 现有功能:

* rbac权限管理

* 系统配置,管理员操作日志等

* 文章,单页,评论,弹幕等

* 数据库备份还原

* 国际化

* todo

## 自己本地部署方法:

进入项目根目录

```
php init

mysql -uroot -proot -e 'create database yii;' //（root root分别是你本地的mysql用户和密码，别直接复制。。。创建yii库，默认名字是yii，如果你不想用这个名字或者用已有的数据库，需要修改common/config/main-local.php里相关的数据库配置）

php yii migrate  //导入demo初始化数据（如果导入失败，可以到console/migrations/里找init.sql直接导入）
```


前台地址: `/web/`

后台地址: `/web/admin/` 管理员 帐号 `hehe` 密码 `111111`

