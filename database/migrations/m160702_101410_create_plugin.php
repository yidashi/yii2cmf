<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%plugin}}`.
 */
class m160702_101410_create_plugin extends Migration
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
        $this->createTable('{{%plugin}}', [
            'id' => $this->string(50)->comment('标识'),
            'name' => $this->string(50)->notNull(),
            'description' => $this->string(128),
            'status' => $this->smallInteger(1)->notNull(),
            'config' => $this->text()->comment('配置'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
            'PRIMARY KEY (`id`)'
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%plugin}}');
    }
}