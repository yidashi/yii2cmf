<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%nav}}`.
 */
class m160716_091753_create_nav_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%nav}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(128),
            'title' => $this->string(128),
        ]);
        $this->createTable('{{%nav_item}}', [
            'id' => $this->primaryKey(),
            'nav_id' => $this->integer(11),
            'title' => $this->string(128),
            'url' => $this->string(128),
            'order' => $this->smallInteger(1),
            'status' => $this->smallInteger(1)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%nav}}');
        $this->dropTable('{{%nav_item}}');
    }
}
