<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%album}}`.
 */
class m160912_051818_create_album_table extends Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%album}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->comment('相册名'),
            'description' => $this->string()->comment('相册描述'),
            'owner_id' => $this->integer(11)->notNull()->comment('相册所有者'),
            'user_id' => $this->integer(11)->notNull()->comment('创建者'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ], $this->tableOptions);
        $this->createTable('{{%album_attachment}}', [
            'album_id' => $this->integer(11)->notNull()->comment('相册ID'),
            'attachment_id' => $this->integer(11)->notNull()->comment('附件ID'),
        ], $this->tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%album}}');
        $this->dropTable('{{%album_attachment}}');
    }
}
