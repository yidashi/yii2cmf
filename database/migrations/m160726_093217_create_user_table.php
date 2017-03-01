<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation for table `{{%user}}`.
 */
class m160726_093217_create_user_table extends Migration
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
        // user
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => $this->string(255)->notNull()->unique(),
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL",
            'password_hash' => Schema::TYPE_STRING . "(255) NOT NULL",
            'password_reset_token' => Schema::TYPE_STRING . "(255) NULL",
            'email' => Schema::TYPE_STRING . "(255) NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'login_at' => Schema::TYPE_INTEGER . "(11) NULL",
            'blocked_at' => $this->integer()->null(),
            'confirmed_at' => $this->integer()->null(),
            'access_token' => $this->string(32)->null(),
            'expired_at' => $this->integer()->null()
        ], $tableOptions);
        // profile
        $this->createTable('{{%profile}}', [
            'user_id' => Schema::TYPE_PK,
            'money' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT 0",
            'signature' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT ''",
            'gender' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0'",
            'qq' => $this->string(20),
            'phone' => $this->string(20),
            'province' => $this->smallInteger(4),
            'city' => $this->smallInteger(4),
            'area' => $this->smallInteger(4),
            'locale' => Schema::TYPE_STRING . "(32) NOT NULL DEFAULT 'zh-CN'",
            'created_at' => Schema::TYPE_INTEGER . "(10) NOT NULL",
            'updated_at' => Schema::TYPE_INTEGER . "(10) NOT NULL"
        ], $tableOptions);

        /*$this->insert('{{%user}}', [
            'username' => 'hehe',
            'auth_key' => '1lQl4TG6sYlyWRqXZEWL0ZhQkPATVnMs',
            'password_hash' => '$2y$13$lYlhIcBcs6jBr7yTd6YrWueckcs.Cvx70juIHs6wEfjtUwnA318VW',
            'email' => 'hehe@xxx.com',
            'created_at' => 1441766741,
            'updated_at' => 1441766741,
            'login_at' => '1441766741',
            'confirmed_at' => '1441766741'
        ]);
        $this->insert('{{%profile}}', [
            'user_id' => 1,
            'locale' => 'zh-CN',
            'created_at' => 1441766741,
            'updated_at' => 1441766741,
        ]);*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%profile}}');
    }
}
