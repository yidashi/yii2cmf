<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * 通知
 */
class m160622_073825_create_notify extends Migration
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
        // notify
        $this->createTable('{{%notify}}', [
            'id' => $this->primaryKey(),
            'from_uid' => $this->integer(11)->notNull(),
            'to_uid' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->comment('通知分类ID'),
            'extra' => $this->text()->comment('附加信息'),
            'created_at' => $this->integer(10)->notNull(),
            'read' => $this->boolean()->notNull()->defaultValue(0),
            'link' => $this->string(255)
        ], $tableOptions);
        $this->createIndex('notify_from_uid_index', '{{%notify}}', 'from_uid');
        $this->createIndex('notify_to_uid_index', '{{%notify}}', 'to_uid');
        $this->createIndex('notify_category_id_index', '{{%notify}}', 'category_id');
        // notify_category
        $this->createTable('{{%notify_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->unique(),
            'title' => $this->string(255),
            'content' => $this->string(255),
        ], $tableOptions);
        $this->batchInsert('{{%notify_category}}', ['name', 'title', 'content'], [
            ['reply', '{from.username} 回复了你的评论', '{extra.comment}'],
            ['suggest', '{from.username} 给你留言了', '{extra.comment}'],
            ['comment', '{from.username} 评论了你的文章 {extra.article_title}', '{extra.comment}'],
            ['favourite', '{from.username} 收藏了你的文章 {extra.article_title}', null],
            ['up_article', '{from.username} 赞了你的文章 {extra.article_title}', null],
            ['message', '{from.username} 给你发了私信', '{extra.message}'],
            ['reward', '{from.username} 打赏了你的文章 {extra.article_title}', '{extra.money} {extra.comment}'],
            ['follow', '{from.username} 关注了你', null],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%notify}}');
        $this->dropTable('{{%notify_category}}');
    }
}
