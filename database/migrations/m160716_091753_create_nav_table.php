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
            'slug' => $this->string(128),
            'title' => $this->string(128),
            'url' => $this->string(128),
            'data' => $this->string(128),
            'type' => $this->string(128),
            'pid' => $this->smallInteger(1),
            'status' => $this->smallInteger(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%nav}}');
    }
}
