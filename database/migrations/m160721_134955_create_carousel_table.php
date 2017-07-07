<?php

use yii\db\Schema;
use yii\db\Migration;

class m160721_134955_create_carousel_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%carousel}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(0)
        ], $tableOptions);

        $this->createTable('{{%carousel_item}}', [
            'id' => $this->primaryKey(),
            'carousel_id' => $this->integer()->notNull(),
            'url' => $this->string(1024),
            'caption' => $this->string(1024),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'order' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }


    public function safeDown()
    {
        $this->dropTable('{{%carousel_item}}');
        $this->dropTable('{{%carousel}}');
    }
}
