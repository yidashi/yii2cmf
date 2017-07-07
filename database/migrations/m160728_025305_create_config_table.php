<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%config}}`.
 */
class m160728_025305_create_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // config
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('配置名'),
            'value' => $this->text()->comment('配置值'),
            'extra' => $this->text()->notNull(),
            'description' => $this->string(255)->comment('配置描述'),
            'type' => $this->string(30)->defaultValue('text')->comment('配置类型'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
            'group' => $this->string(30)->defaultValue('system')->comment('配置分组')
        ], $tableOptions);
        $this->execute(<<<SQL
INSERT INTO {{%config}} VALUES (1,'config_type_list','text=>字符\r\narray=>数组\r\npassword=>密码\r\nimage=>图片\r\ntextarea=>多行字符\r\nselect=>下拉框\r\nradio=>单选框\r\ncheckbox=>多选框\r\neditor=>富文本编辑器','','配置类型列表','array',0,1461937892,'system'),
(2,'config_group','site=>网站\r\nsystem=>系统','','配置分组','array',1468405444,1468421137,'system'),
(3,'site_name','yii2cmf','','网站名称','text',0,1461937892,'site'),
(4,'site_icp','','','域名备案号','text',0,1461937892,'site'),
(5,'site_logo','','','网站LOGO','image',0,1461937892,'site'),
(6,'seo_site_description','yiicmf2','','meta description','text',0,1468403120,'site'),
(7,'seo_site_keywords','yiicmf','','meta keywords','text',0,1461937892,'site'),
(8,'theme_name','basic','','主题名','text',0,1467882452,'site'),
(9,'backend_skin','skin-black','skin-black=>skin-black\r\nskin-black-light=>skin-black-light\r\nskin-blue=>skin-blue\r\nskin-blue-light=>skin-blue-light\r\nskin-green=>skin-green\r\nskin-green-light=>skin-green-light\r\nskin-purple=>skin-purple\r\nskin-pruple-light=>skin-purple-light\r\nskin-red=>skin-red\r\nskin-red-light=>skin-red-light\r\nskin-yellow=>skin-yellow\r\nskin-yellow-light=>skin-yellow-light','后台皮肤','select',1461931367,1461937892,'system'),
(10,'editor_type_list','ueditor=>ueditor\r\nmarkdown=>markdown\r\nredactor=>redactor','','支持的编辑器类型','array',0,1468406411,'system'),
(11,'article_editor_type','ueditor','editor_type_list','文章编辑器','select',0,1468406411,'system'),
(12,'page_editor_type','ueditor','editor_type_list','单页编辑器','select',0,1468406411,'system');
SQL
);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
