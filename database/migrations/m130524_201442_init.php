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
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL COMMENT '状态'",
            'view' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'is_top' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否置顶'),
            'is_hot' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否热门'),
            'is_best' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否精华'),
            'description' => $this->string(255)->notNull()->defaultValue('')->comment('摘要'),
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'source' => $this->string(255)->notNull()->defaultValue('')->comment('来源'),
            'deleted_at' => Schema::TYPE_INTEGER . "(10)",
            'favourite' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'published_at' => Schema::TYPE_INTEGER . "(10) NOT NULL DEFAULT '0'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);
        $this->createIndex('index_published_at', '{{%article}}', 'published_at');
// article_data
        $this->createTable('{{%article_data}}', [
            'id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'content' => Schema::TYPE_TEXT . " NOT NULL",
            'markdown' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否markdown格式'),
            'PRIMARY KEY (id)',
        ], $this->tableOptions);

// article_tag
        $this->createTable('{{%article_tag}}', [
            'article_id' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);
// meta
        $this->createTable('{{%meta}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128),
            'keywords' => $this->string(128),
            'description' => $this->string(128),
            'entity' => $this->string(80),
            'entity_id' => $this->integer()
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
            'allow_publish' => $this->smallInteger(1)->defaultValue('1')->comment('是否允许发布内容')
        ], $this->tableOptions);

// comment
        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'user_ip' => $this->string(20)->comment('用户ip')->defaultValue(''),
            'entity' => Schema::TYPE_STRING . "(80) NOT NULL",
            'entity_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '内容'",
            'parent_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
            'reply_uid' => $this->integer(11)->defaultValue('0'),
            'is_top' => Schema::TYPE_SMALLINT . "(1) NOT NULL DEFAULT '0'",
            'status' => Schema::TYPE_SMALLINT . "(1) NOT NULL DEFAULT '1'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);
        $this->createIndex('entity', '{{%comment}}', ['entity', 'entity_id']);
// comment_info
        $this->createTable('{{%comment_info}}', [
            'id' => Schema::TYPE_PK,
            'entity' => $this->string(80)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'total' => $this->integer(11)->notNull()
        ], $this->tableOptions);
        $this->createIndex('entity', '{{%comment_info}}', ['entity', 'entity_id']);
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
            'url_org' => Schema::TYPE_STRING . "(255) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// page
        $this->createTable('{{%page}}', [
            'id' => Schema::TYPE_PK,
            'use_layout' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1' COMMENT '0:不使用1:使用'",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '内容'",
            'title' => Schema::TYPE_STRING . "(50) NOT NULL COMMENT '标题'",
            'slug' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT ''",
            'markdown' => $this->smallInteger(1)->defaultValue(0)->comment('是否markdown格式'),
            'created_at' => Schema::TYPE_INTEGER . "(10) NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NULL",
        ], $this->tableOptions);

// reward
        $this->createTable('{{%reward}}', [
            'id' => Schema::TYPE_PK,
            'article_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'money' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'comment' => $this->string(50)->defaultValue('')->comment('留言'),
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
        ], $this->tableOptions);

// sign 签到表
        $this->createTable('{{%sign}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'last_sign_at' => Schema::TYPE_INTEGER . "(10) NOT NULL COMMENT '上次签到时间'",
            'times' => Schema::TYPE_INTEGER . "(11) NOT NULL COMMENT '总签到次数'",
            'continue_times' => Schema::TYPE_INTEGER . "(11) NOT NULL COMMENT '连续签到次数'",
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
            'entity' => Schema::TYPE_STRING . "(80) NOT NULL",
            'entity_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'action' => Schema::TYPE_STRING . "(20) NOT NULL DEFAULT 'up' COMMENT 'up or down'",
        ], $this->tableOptions);
//vote_info
        $this->createTable('{{%vote_info}}', [
            'id' => Schema::TYPE_PK,
            'entity' => $this->string(80)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'up' => $this->integer(11)->notNull()->defaultValue('0')->comment('顶数'),
            'down' => $this->integer(11)->notNull()->defaultValue('0')->comment('踩数'),
        ], $this->tableOptions);
        $this->createIndex('entity', '{{%vote_info}}', ['entity', 'entity_id']);
        $this->insert('{{%page}}', [
            'use_layout' => 1,
            'content' => '关于我们',
            'title' => '关于我们',
            'slug' => 'aboutus',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%category}}', [
            'slug' => 'default',
            'title' => '默认',
            'allow_publish' => '2',
            'created_at' => time(),
            'updated_at' => time()
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
        $this->dropTable('{{%meta}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%comment_info}}');
        $this->dropTable('{{%favourite}}');
        $this->dropTable('{{%gather}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%reward}}');
        $this->dropTable('{{%sign}}');
        $this->dropTable('{{%spider}}');
        $this->dropTable('{{%system_log}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%vote}}');
        $this->dropTable('{{%vote_info}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
