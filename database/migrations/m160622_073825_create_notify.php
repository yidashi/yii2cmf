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
            'from_uid' => $this->integer(11)->notNull(),
            'to_uid' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->comment('通知分类ID'),
            'extra' => $this->text()->comment('附加信息'),
            'created_at' => $this->integer(10)->notNull(),
            'read' => $this->boolean()->notNull()->defaultValue(0),
            'link' => $this->string(255)
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
            ['up_article', '{from.username} 赞了你的文章 {extra.article_title}', null],
            ['message', '{from.username} 给你发了私信', '{extra.message}']
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
