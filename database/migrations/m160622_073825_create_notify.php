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
        // notify
        $this->createTable('{{%notify}}', [
            'id' => $this->primaryKey(),
            'from_uid' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'to_uid' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'category_id' => $this->integer(11)->comment('通知分类ID'),
            'extra' => $this->text()->comment('附加信息'),
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'read' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0'",
            'link' => Schema::TYPE_STRING . "(255) NULL",
        ]);
        // notify_category
        $this->createTable('{{%notify_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->unique(),
            'title' => $this->string(255),
            'content' => $this->string(255),
        ]);
        $this->batchInsert('{{%notify_category}}', ['name', 'title', 'content'], [
            ['reply', '{from.username} 回复了你的评论', '{extra.comment}'],
            ['suggest', '{from.username} 给你留言了', '{extra.comment}'],
            ['comment', '{from.username} 评论了你的文章 {extra.article_title}', '{extra.comment}'],
            ['favourite', '{from.username} 收藏了你的文章 {extra.article_title}', null],
            ['up_article', '{from.username} 赞了你的文章 {extra.article_title}', null]
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
