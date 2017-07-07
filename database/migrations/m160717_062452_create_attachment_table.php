<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%attachment}}`.
 */
class m160717_062452_create_attachment_table extends Migration
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
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'name' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->string(255)->null(),
            'path' => $this->string(255)->notNull(),
            'hash' => $this->string(64)->notNull(),
            'size' => $this->integer(11),
            'type' => $this->string(255),
            'extension' => $this->string(255),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ], $tableOptions);
        $this->createTable('{{%attachment_index}}', [
            'attachment_id' => $this->integer(11)->notNull(),
            'entity' => $this->string(80)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'attribute' => $this->string(20)->notNull()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%attachment}}');
        $this->dropTable('{{%attachment_index}}');
    }
}
