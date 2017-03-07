<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%url_rule}}`.
 */
class m170306_133529_create_url_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%url_rule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->null(),
            'pattern' => $this->string(255)->notNull(),
            'host' => $this->string(255)->null(),
            'route' => $this->string(255)->notNull(),
            'defaults' => $this->string(255)->null(),
            'suffix' => $this->string(255)->null(),
            'verb' => $this->string(255)->null(),
            'mode' => $this->boolean()->notNull()->defaultValue('0'),
            'encodeParams' => $this->boolean()->notNull()->defaultValue('1'),
            'status' => $this->smallInteger(1)->null()->defaultValue('1'),
            'sort' => $this->smallInteger(1)->null()->defaultValue('1')->comment('排序'),
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
        $this->batchInsert('{{%url_rule}}', ['pattern', 'route', 'suffix'], [
            ['<id:\d+>', '/article/view', '.html'],
            ['tag/search', 'tag/search', null],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%url_rule}}');
    }
}
