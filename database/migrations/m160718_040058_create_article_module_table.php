<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%article_module}}`.
 */
class m160718_040058_create_article_module_table extends Migration
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
        $this->createTable('{{%article_module}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'title' => $this->string(50),
            'model' => $this->string(128)
        ], $tableOptions);
        $this->createTable('{{%article_exhibition}}', [
            'id' => $this->integer(11)->unique(),
            'start_at' => $this->dateTime()->comment('开始时间'),
            'end_at' => $this->dateTime()->comment('结束时间'),
            'city' => $this->string(50)->comment('举办城市'),
            'address' => $this->string(255)->comment('举办地址')
        ], $tableOptions);
        $moduleColumn = new \yii\db\ColumnSchemaBuilder('string');
        $moduleColumn->comment('文档类型');
        $moduleColumn->defaultValue('base');// 默认普通文章
        $this->addColumn('{{%article}}', 'module', $moduleColumn);
        $this->addColumn('{{%category}}', 'module', $moduleColumn);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%article_module}}');
        $this->dropTable('{{%article_exhibition}}');
        $this->dropColumn('{{%article}}', 'module');
        $this->dropColumn('{{%category}}', 'module');
    }
}
