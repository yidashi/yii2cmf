<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%city}}`.
 */
class m160712_030817_create_city_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('地区名'),
            'parent_id' => $this->integer(11)->comment('父ID'),
            'sort' => $this->smallInteger(1)->comment('排序'),
            'deep' => $this->smallInteger(1)->comment('地区深度,冗余字段')
        ]);
        $this->createIndex('parent_id', '{{%city}}', 'parent_id');
        $this->execute(file_get_contents(__DIR__ . '/city.sql'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
