<?php

use yii\db\Migration;
use yii\db\Schema;

class m130524_201442_init extends Migration
{
    public $tableOptions;

    public function safeUp()
    {
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
            'comment' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'up' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'down' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'view' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'is_top' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否置顶'),
            'desc' => Schema::TYPE_STRING . "(255) NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'source' => Schema::TYPE_STRING . "(50) NOT NULL",
            'deleted_at' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
            'favourite' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'published_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
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

// auth_assignment
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => Schema::TYPE_STRING . "(64) NOT NULL",
            'user_id' => Schema::TYPE_STRING . "(64) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'PRIMARY KEY (item_name, user_id)',
        ], $this->tableOptions);

// auth_item
        $this->createTable('{{%auth_item}}', [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL",
            'type' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'description' => Schema::TYPE_TEXT . " NULL",
            'rule_name' => Schema::TYPE_STRING . "(64) NULL",
            'data' => Schema::TYPE_TEXT . " NULL",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

// auth_item_child
        $this->createTable('{{%auth_item_child}}', [
            'parent' => Schema::TYPE_STRING . "(64) NOT NULL",
            'child' => Schema::TYPE_STRING . "(64) NOT NULL",
            'PRIMARY KEY (parent, child)',
        ], $this->tableOptions);

// auth_rule
        $this->createTable('{{%auth_rule}}', [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL",
            'data' => Schema::TYPE_TEXT . " NULL",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

// category
        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '名字'",
            'pid' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0' COMMENT '父id'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'name' => Schema::TYPE_STRING . "(20) NOT NULL",
            'description' => Schema::TYPE_STRING . "(1000) NOT NULL DEFAULT ''",
            'article' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
            'is_nav' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1'",
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
// config
        $this->createTable('{{%config}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '配置键值'",
            'value' => Schema::TYPE_TEXT . " NOT NULL COMMENT '配置值'",
            'extra' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
            'desc' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '配置描述'",
            'type' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

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
            'name' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT ''",
            'created_at' => Schema::TYPE_INTEGER . "(10) NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NULL",
        ], $this->tableOptions);

// profile
        $this->createTable('{{%profile}}', [
            'id' => Schema::TYPE_PK,
            'money' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'signature' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT ''",
            'avatar' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
            'gender' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0'",
            'qq' => $this->string(20),
            'phone' => $this->string(20),
            'locale' => Schema::TYPE_STRING . "(32) NOT NULL DEFAULT 'zh-CN'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL"
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

// user
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => $this->string(255)->notNull()->unique(),
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL",
            'password_hash' => Schema::TYPE_STRING . "(255) NOT NULL",
            'password_reset_token' => Schema::TYPE_STRING . "(255) NULL",
            'email' => Schema::TYPE_STRING . "(255) NOT NULL",
            'status' => Schema::TYPE_SMALLINT . "(6) NOT NULL DEFAULT '10'",
            'created_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'is_admin' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0'",
            'login_at' => Schema::TYPE_INTEGER . "(11) NULL",
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

// fk: auth_assignment
        $this->addForeignKey('fk_auth_assignment_item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name');

// fk: auth_item
        $this->addForeignKey('fk_auth_item_rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name');

// fk: auth_item_child
        $this->addForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name');
        $this->addForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name');

// fk: menu
        $this->addForeignKey('fk_menu_parent', '{{%menu}}', 'parent', '{{%menu}}', 'id');

        $this->execute(file_get_contents(__DIR__ .'/init.sql'));
    }

    public function safeDown()
    {
        $this->dropTable('{{%admin_log}}');
        $this->dropTable('{{%article}}');
        $this->dropTable('{{%article_data}}');
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%auth_assignment}}'); // fk: item_name
        $this->dropTable('{{%auth_item_child}}'); // fk: parent, child
        $this->dropTable('{{%auth_item}}'); // fk: rule_name
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%config}}');
        $this->dropTable('{{%favourite}}');
        $this->dropTable('{{%gather}}');
        $this->dropTable('{{%menu}}'); // fk: parent
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%reward}}');
        $this->dropTable('{{%sign}}');
        $this->dropTable('{{%spider}}');
        $this->dropTable('{{%subscribe}}');
        $this->dropTable('{{%suggest}}');
        $this->dropTable('{{%system_log}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%vote}}');

    }
}
