<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%area}}`.
 */
class m160722_114202_create_area_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%area}}', [
            'area_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            'title' => 'VARCHAR(255) NOT NULL',
            'slug' => 'VARCHAR(255) NOT NULL',
            'description' => 'VARCHAR(255) NOT NULL',
            'blocks' => 'VARCHAR(255) NOT NULL',
            'PRIMARY KEY (`area_id`)'
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");

        $this->createTable('{{%area_block}}', [
            'block_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            'title' => 'VARCHAR(255) NOT NULL',
            'type' => 'VARCHAR(50) NULL',
            'widget' => 'TEXT NULL',
            'slug' => 'VARCHAR(255) NOT NULL',
            'config' => 'TEXT NULL',
            'template' => 'TEXT NULL',
            'cache' => 'INT(11) NOT NULL',
            'used' => 'SMALLINT(6) NOT NULL',
            'PRIMARY KEY (`block_id`)'
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%area}}');
        $this->dropTable('{{%area_block}}');
    }
}
