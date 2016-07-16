<?php

namespace plugins\donation\migrations;

use yii\db\Migration;

/**
 * Handles the creation for table `{{%donation}}`.
 */
class Migrate extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%donation}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'money' => $this->decimal()->notNull(),
            'remark' => $this->string(255)->comment('留言'),
            'source' => $this->string(255)->comment('来源'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%donation}}');
    }
}
