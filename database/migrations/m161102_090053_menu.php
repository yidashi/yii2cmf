<?php

use yii\db\Migration;

class m161102_090053_menu extends Migration
{
    public function safeUp()
    {
		$this->execute('SET foreign_key_checks = 0');
        $this->createTable('{{%menu}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            'name' => 'VARCHAR(128) NOT NULL',
            'parent' => 'INT(11) NULL',
            'route' => 'VARCHAR(256) NULL',
            'order' => 'INT(11) NULL',
            'data' => 'TEXT NULL',
            'icon' => 'VARCHAR(50) NULL',
            'PRIMARY KEY (`id`)'
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");

        $this->createIndex('parent','{{%menu}}','parent',0);
        $this->addForeignKey('pop_menu_ibfk_1', '{{%menu}}', 'parent', '{{%menu}}', 'id', 'SET NULL', 'CASCADE' );

        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');

        /* Table yii2cmf_menu */
        $this->batchInsert('{{%menu}}',['id','name','parent','route','order','data','icon'],[
            ['24','系统','','','1','','fa-cog'],
            ['39','内容','','','2','','fa-edit'],
            ['46','网站','','','3','','fa-desktop'],
            ['33','用户','','','4','','fa-users'],
            ['44','插件','','','5','','fa-plug'],
            ['71','配置','','','6','',''],
            ['30','数据库','','','7','','fa-book'],
            ['15','用户管理','33','/user/default/index','1','','fa-user'],
            ['16','路由管理','33','/rbac/route/index','3','','fa-link'],
            ['17','角色管理','33','/rbac/role/index','2','','fa-user-md'],
            ['22','内容列表','39','/document/document/index','1','',''],
            ['25','系统配置','71','/config/default/index','1','',''],
            ['26','自定义配置','71','/config/custom/index','2','',''],
            ['27','单页管理','39','/page/index','39','',''],
            ['29','分类管理','39','/document/category/index','5','',''],
            ['31','备份','30','/backup/export/index','1','',''],
            ['32','还原','30','/backup/import/index','2','',''],
            ['34','菜单管理','24','/rbac/menu/index','3','','fa-navicon'],
            ['37','操作记录','24','/admin-log/index','5','','fa-envelope-o'],
            ['40','发布内容','39','/document/document/create','2','','fa-plus'],
            ['41','回收站','39','/document/document/trash','3','',''],
            ['42','评论管理','39','/comment/default/index','6','',''],
            ['43','留言板','39','/suggest/index','7','',''],
            ['45','插件管理','44','/plugin/index','','',''],
            ['47','模块管理','44','/module/index','','',''],
            ['48','主题','46','/theme/default/index','4','',''],
            ['49','幻灯片','46','/carousel/index','5','',''],
            ['50','导航','46','/nav/index','1','',''],
            ['51','区域','46','/area/area/index','2','',''],
            ['52','区块','46','/area/block/index','3','',''],
            ['57','规则管理','33','/rbac/rule/index','5','','fa-sitemap'],
            ['58','权限管理','33','/rbac/permission/index','4','','fa-check-square'],
            ['66','群发站内信','46','/message/default/create','4','','fa-comment-o'],
            ['67','错误日志','24','/log/index','5','','fa-warning'],
            ['68','控制面板','24','/site/dashboard','1','','fa-dashboard'],
            ['72','数据库配置','71','/config/default/database','3','',''],
            ['73','邮箱配置','71','/config/default/mail','4','',''],
            ['75','缓存','24','/cache/index','8','','fa-flash'],
            ['76','附件','39','/attachment/default/index','9','','fa-file-picture-o'],
            ['77','标签','39','/tag/index','10','','fa-tags'],
            ['78','路由规则','46','/urlrule/default/index','6','',''],
            ['81','内容模型','39','/document/document-module/index','4','',''],
        ]);
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
