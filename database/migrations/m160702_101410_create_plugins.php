<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%module}}`.
 */
class m160702_101410_create_plugins extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique()->comment('标识'),
            'title' => $this->string(50)->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
            'author' => $this->string(50)->comment('作者'),
            'version' => $this->string(50)->comment('版本'),
            'desc' => $this->string(255)->comment('说明'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%module}}');
    }
}
