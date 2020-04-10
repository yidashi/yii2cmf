<?php

namespace common\modules\i18n;

use yii\db\Schema;
use yii\db\Migration;

class migrate extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%i18n_source_message}}', [
            'id'=>$this->primaryKey(),
            'category'=>$this->string(32),
            'message'=>$this->text()
        ], $tableOptions);

        $this->createTable('{{%i18n_message}}', [
            'id'=>$this->integer(),
            'language'=>$this->string(16),
            'translation'=>$this->text()
        ], $tableOptions);

        $this->addPrimaryKey('i18n_message_pk', '{{%i18n_message}}', ['id', 'language']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%i18n_message}}');
        $this->dropTable('{{%i18n_source_message}}');
    }
}
