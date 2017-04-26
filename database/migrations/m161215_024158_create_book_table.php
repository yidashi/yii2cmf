<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%book}}`.
 */
class m161215_024158_create_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'book_name' => $this->string(50)->notNull()->comment('书名'),
            'book_author' => $this->integer(11)->notNull()->comment('作者'),
            'book_link' => $this->string(128)->comment('书外链'),
            'book_description' => $this->string(1000)->notNull()->comment('书简介'),
            'category_id' => $this->integer(11)->notNull()->comment('书分类'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%book_chapter}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(11)->notNull()->comment('书'),
            'chapter_name' => $this->string(80)->notNull()->comment('章节标题'),
            'chapter_body' => $this->text()->comment('章节正文'),
            'pid' => $this->integer(11)->notNull()->defaultValue(0),
            'sort' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createTable('{{%book_category}}', [
            'id' => $this->primaryKey(),
            'category_name' => $this->string(80)->notNull()->comment('分类名'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%book_chapter}}');
        $this->dropTable('{{%book_category}}');
    }
}
