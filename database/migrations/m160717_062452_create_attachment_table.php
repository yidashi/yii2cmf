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
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'name' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->string(255)->null(),
            'url' => $this->string(255)->notNull(),
            'hash' => $this->string(64)->notNull(),
            'size' => $this->integer(11),
            'type' => $this->string(255),
            'extension' => $this->string(255),
            'created_at' => $this->integer(10),
            'updated_at' => $this->integer(10)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%attachment}}');
    }
}
