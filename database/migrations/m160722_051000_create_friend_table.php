<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%friend}}`.
 */
class m160722_051000_create_friend_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%friend}}', [
            'owner_id' => $this->integer()->notNull(),
            'friend_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('friend', '{{%friend}}', ['owner_id', 'friend_id'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%friend}}');
    }
}
