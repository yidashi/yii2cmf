<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%attachment}}`.
 */
class m160717_062452_create_attachment_table extends Migration
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
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'name' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->string(255)->null(),
            'path' => $this->string(255)->notNull(),
            'hash' => $this->string(64)->notNull(),
            'size' => $this->integer(11),
            'type' => $this->string(255),
            'extension' => $this->string(255),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ], $tableOptions);
        $this->createTable('{{%attachment_index}}', [
            'attachment_id' => $this->integer(11)->notNull(),
            'entity' => $this->string(80)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'attribute' => $this->string(20)->notNull()
        ], $tableOptions);
        $this->insert('{{%module}}', [
            'id' => 'attachment',
            'name' => '附件',
            'bootstrap' => 'app-frontend|app-backend',
            'status' => 1,
            'type' => 1,
            'config' => '[{"name":"filesystem_type","type":"radio","value":"local","desc":"文件系统","extra":{"local":"本地","qiniu":"七牛"}},{"name":"qiniu_access_key","type":"text","value":"","desc":"七牛access_key"},{"name":"qiniu_access_secret","type":"text","value":"","desc":"七牛access_secret"},{"name":"qiniu_bucket","type":"text","value":"","desc":"七牛bucket"},{"name":"qiniu_domain","type":"text","value":"","desc":"七牛域名"}]',
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%attachment}}');
        $this->dropTable('{{%attachment_index}}');
    }
}
