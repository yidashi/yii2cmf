demo地址 `www.51siyuan.cn`

demo后台地址: `www.51siyuan.cn/admin`  帐号 `demo` 密码 `111111`

## 安装:

进入项目根目录

1. ` php init `

    > 0回车 yes回车

2. 创建项目所需数据库 `mysql -uroot -proot -e 'create database yii;'`

    > root root分别是你的mysql用户和密码，创建yii库

3. 数据库配置

    > 修改`common/config/main-local.php`
    
    ```
    'db' => ['class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=yii', //数据库host和库名
        'username' => 'root', // 数据库用户名
        'password' => 'root1234', // 数据库密码
        'charset' => 'utf8',
        'tablePrefix' => 'pop_', // 表前缀
    ],
    ```
    
4. 导入初始化数据 `php yii migrate` 

5. 收工

    > 前台访问地址: `/web/`

    > 后台访问地址: `/web/admin/` 管理员 帐号 `hehe` 密码 `111111`
    
## 现有功能:

* rbac权限管理

* 系统配置,管理员操作日志等

* 文章,单页,评论,弹幕等

* 数据库备份还原

* 国际化

* 主题、皮肤

* todo


