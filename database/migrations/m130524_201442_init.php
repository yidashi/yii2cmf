<?php

use yii\db\Migration;
use yii\db\Schema;

class m130524_201442_init extends Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {
        $this->execute('SET foreign_key_checks = 0');
        // admin_log
        $this->createTable('{{%admin_log}}', [
            'id' => Schema::TYPE_PK,
            'route' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
            'description' => Schema::TYPE_TEXT . " NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
            'ip' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
        ], $this->tableOptions);

// article
        $this->createTable('{{%article}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '标题'",
            'category' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '分类'",
            'category_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL COMMENT '状态'",
            'cover' => Schema::TYPE_STRING . "(255) NULL COMMENT '封面'",
            'comment' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'up' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'down' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'view' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'is_top' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否置顶'),
            'is_hot' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否热门'),
            'is_best' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否精华'),
            'description' => Schema::TYPE_STRING . "(255) NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'source' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
            'deleted_at' => Schema::TYPE_INTEGER . "(10)",
            'favourite' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'published_at' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
        ], $this->tableOptions);

// article_data
        $this->createTable('{{%article_data}}', [
            'id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'content' => Schema::TYPE_TEXT . " NOT NULL",
            'PRIMARY KEY (id)',
        ], $this->tableOptions);

// article_tag
        $this->createTable('{{%article_tag}}', [
            'article_id' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// auth
        $this->createTable('{{%auth}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'source' => Schema::TYPE_STRING . "(255) NOT NULL",
            'source_id' => Schema::TYPE_STRING . "(255) NOT NULL",
        ], $this->tableOptions);

// category
        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '名字'",
            'pid' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0' COMMENT '父id'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'slug' => Schema::TYPE_STRING . "(20) NOT NULL",
            'description' => Schema::TYPE_STRING . "(1000) NOT NULL DEFAULT ''",
            'article' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
            'sort' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0'",
        ], $this->tableOptions);

// comment
        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'type_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '内容'",
            'parent_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'up' => Schema::TYPE_INTEGER . "(1) NOT NULL DEFAULT '0'",
            'down' => Schema::TYPE_INTEGER . "(1) NOT NULL DEFAULT '0'",
            'is_top' => Schema::TYPE_SMALLINT . "(1) NOT NULL DEFAULT '0'",
            'type' => Schema::TYPE_STRING . "(20) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%comment}}', ['type', 'type_id']);

// favourite
        $this->createTable('{{%favourite}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'article_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// gather
        $this->createTable('{{%gather}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NOT NULL",
            'category' => Schema::TYPE_STRING . "(255) NOT NULL",
            'url' => Schema::TYPE_STRING . "(255) NOT NULL",
            'url_org' => Schema::TYPE_STRING . "(255) NOT NULL",
            'res' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1'",
            'result' => Schema::TYPE_STRING . "(255) NOT NULL",
        ], $this->tableOptions);

// menu
        $this->createTable('{{%menu}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(128) NOT NULL",
            'parent' => Schema::TYPE_INTEGER . "(11) NULL",
            'route' => Schema::TYPE_STRING . "(256) NULL",
            'order' => Schema::TYPE_INTEGER . "(11) NULL",
            'data' => Schema::TYPE_TEXT . " NULL",
            'icon' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT ''",
        ], $this->tableOptions);

// page
        $this->createTable('{{%page}}', [
            'id' => Schema::TYPE_PK,
            'use_layout' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1' COMMENT '0:不使用1:使用'",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '内容'",
            'title' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '标题'",
            'slug' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT ''",
            'created_at' => Schema::TYPE_INTEGER . "(10) NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NULL",
        ], $this->tableOptions);

// reward
        $this->createTable('{{%reward}}', [
            'id' => Schema::TYPE_PK,
            'article_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'money' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// sign
        $this->createTable('{{%sign}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'last_sign_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'times' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'continue_times' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

// spider
        $this->createTable('{{%spider}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '标识'",
            'title' => Schema::TYPE_STRING . "(100) NOT NULL COMMENT '名称'",
            'domain' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '域名'",
            'page_dom' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '分页链接元素'",
            'list_dom' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '列表链接元素'",
            'time_dom' => Schema::TYPE_STRING . "(255) NULL COMMENT '内容页时间元素'",
            'content_dom' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '内容页内容元素'",
            'title_dom' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '内容页标题元素'",
            'target_category' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '目标分类'",
            'target_category_url' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '目标分类地址'",
        ], $this->tableOptions);

// subscribe
        $this->createTable('{{%subscribe}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'email' => Schema::TYPE_STRING . "(30) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// suggest
        $this->createTable('{{%suggest}}', [
            'id' => Schema::TYPE_PK,
            'content' => Schema::TYPE_TEXT . " NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

// system_log
        $this->createTable('{{%system_log}}', [
            'id' => Schema::TYPE_BIGPK,
            'level' => Schema::TYPE_INTEGER . "(11) NULL",
            'category' => Schema::TYPE_STRING . "(255) NULL",
            'log_time' => Schema::TYPE_DOUBLE . " NULL",
            'prefix' => Schema::TYPE_TEXT . " NULL",
            'message' => Schema::TYPE_TEXT . " NULL",
        ], $this->tableOptions);

// tag
        $this->createTable('{{%tag}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(100) NOT NULL",
            'article' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0' COMMENT '有该标签的文章数'",
        ], $this->tableOptions);

// vote
        $this->createTable('{{%vote}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING . "(20) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'action' => Schema::TYPE_STRING . "(20) NOT NULL DEFAULT 'up'",
            'type_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

        $this->insert('{{%page}}', [
            'use_layout' => 1,
            'content' => '关于我们',
            'title' => '关于我们',
            'slug' => 'aboutus',
            'created_at' => 1441766741,
            'updated_at' => 1441766741
        ]);
        $this->execute('SET foreign_key_checks = 1');
    }

    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%admin_log}}');
        $this->dropTable('{{%article}}');
        $this->dropTable('{{%article_data}}');
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%favourite}}');
        $this->dropTable('{{%gather}}');
        $this->dropTable('{{%menu}}'); // fk: parent
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%reward}}');
        $this->dropTable('{{%sign}}');
        $this->dropTable('{{%spider}}');
        $this->dropTable('{{%subscribe}}');
        $this->dropTable('{{%suggest}}');
        $this->dropTable('{{%system_log}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%vote}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
