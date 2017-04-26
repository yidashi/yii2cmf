<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%module}}`.
 */
class m160702_101410_create_module extends Migration
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
        $this->createTable('{{%module}}', [
            'id' => $this->string(50)->notNull()->unique()->comment('标识'),
            'name' => $this->string(50)->notNull(),
            'bootstrap' => $this->string(128)->comment('模块初始化应用ID'),
            'status' => $this->smallInteger(1)->notNull(),
            'type' => $this->smallInteger(1)->notNull()->comment('模块类型1module2plugin'),
            'config' => $this->text()->comment('配置'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('id', '{{%module}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%module}}');
    }
}
