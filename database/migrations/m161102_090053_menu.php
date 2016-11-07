<?php

use yii\db\Migration;

class m161102_090053_menu extends Migration
{
    public function up()
    {
		$this->execute('SET foreign_key_checks = 0');
        $this->createTable('{{%menu}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            'name' => 'VARCHAR(128) NOT NULL',
            'parent' => 'INT(11) NULL',
            'route' => 'VARCHAR(256) NULL',
            'order' => 'INT(11) NULL',
            'data' => 'TEXT NULL',
            'icon' => 'VARCHAR(50) NOT NULL',
            'PRIMARY KEY (`id`)'
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");

        $this->createIndex('parent','{{%menu}}','parent',0);
        $this->addForeignKey('pop_menu_ibfk_1', '{{%menu}}', 'parent', '{{%menu}}', 'id', 'SET NULL', 'CASCADE' );

        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');

        /* Table yii2cmf_menu */
        $this->batchInsert('{{%menu}}',['id','name','parent','route','order','data','icon'],[['15','用户管理','33','/user/admin/index','','',''],
            ['16','路由管理','33','/rbac/route/index','','',''],
            ['17','角色管理','33','/rbac/role/index','','',''],
            ['22','文章列表','39','/article/index','1','',''],
            ['24','系统','','','1','','cog'],
            ['25','配置','24','/config/default/index','2','',''],
            ['26','自定义配置','24','/config/custom/index','3','',''],
            ['27','单页管理','39','/page/index','40','',''],
            ['29','分类管理','39','/category/index','4','',''],
            ['30','数据库','','','8','','book'],
            ['31','备份','30','/backup/export/index','','',''],
            ['32','还原','30','/backup/import/index','','',''],
            ['33','用户','','','2','','users'],
            ['34','菜单管理','24','/rbac/menu/index','5','',''],
            ['37','操作记录','24','/admin-log/index','7','',''],
            ['39','内容','','','3','','edit'],
            ['40','发布文章','39','/article/create','2','',''],
            ['41','回收站','39','/article/trash','3','',''],
            ['42','评论管理','39','/comment/index','6','',''],
            ['43','留言板','39','/suggest/index','7','',''],
            ['44','插件','','','7','','plug'],
            ['45','插件管理','44','/plugins/index','','',''],
            ['46','外观','','','4','','tv'],
            ['47','主题','46','/theme/index','4','',''],
            ['48','幻灯片','46','/carousel/index','5','',''],
            ['49','导航','46','/nav/index','1','',''],
            ['50','区域','46','/area/index','2','',''],
            ['51','区块','46','/block/index','3','',''],
            ['52','采集','','','5','','retweet'],
            ['53','蜘蛛','52','/spider/index','1','',''],
            ['54','国际化','','','6','','flag'],
            ['55','source message','54','/i18n/i18n-source-message/index','1','',''],
            ['56','国际化信息','54','/i18n/i18n-message/index','2','',''],
            ['57','规则管理','33','/rbac/rule/index','5','',''],
            ['58','权限管理','33','/rbac/permission/index','4','',''],
            ['65','捐赠','44','/donation/index','2','',''],
            ['66','群发站内信','24','/message/admin/create','6','',''],
            ['67','错误日志','24','/log/index','7','',''],
            ['68','控制面板','24','/site/index','1','',''],
            ['69','GII','24','/gii/default/index','8','',''],
            ['70','迁移','24','/migration/default/index','9','',''],
        ]);
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
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
