<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%message}}`.
 */
class m160806_074300_create_message_table extends Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'from_uid' => $this->integer(11)->notNull(),
            'to_uid' => $this->integer(11)->notNull(),
            'message_id' => $this->integer(11)->notNull()->comment('消息ID'),
            'read' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否阅读')
        ], $this->tableOptions);
        $this->createTable('{{%message_data}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->comment('消息内容'),
            'group' => $this->string(128),
            'created_at' => $this->integer(10)->notNull()
        ], $this->tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%message_data}}');
    }
}
