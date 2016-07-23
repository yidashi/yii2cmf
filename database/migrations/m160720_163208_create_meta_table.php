<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%meta}}`.
 */
class m160720_163208_create_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%meta}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128),
            'keywords' => $this->string(128),
            'description' => $this->string(128),
            'type' => $this->string(128),
            'type_id' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%meta}}');
    }
}
