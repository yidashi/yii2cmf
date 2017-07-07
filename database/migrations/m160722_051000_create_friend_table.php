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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%friend}}', [
            'owner_id' => $this->integer()->notNull()->comment('自己'),
            'friend_id' => $this->integer()->notNull()->comment('朋友'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
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
