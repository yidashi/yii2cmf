<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%document_module}}`.
 */
class m160718_040058_create_document_module_table extends Migration
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
        $this->createTable('{{%document_module}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'title' => $this->string(50),
        ], $tableOptions);
        $this->createTable('{{%document_exhibition}}', [
            'id' => $this->integer(11),
            'start_at' => $this->dateTime()->comment('开始时间'),
            'end_at' => $this->dateTime()->comment('结束时间'),
            'city' => $this->string(50)->comment('举办城市'),
            'address' => $this->string(255)->comment('举办地址'),
            'PRIMARY KEY (id)',
        ], $tableOptions);
        $moduleColumn = new \yii\db\ColumnSchemaBuilder('string');
        $moduleColumn->comment('内容模型');
        $moduleColumn->defaultValue('article');// 默认普通文章
        $this->addColumn('{{%document}}', 'module', $moduleColumn);
        $this->addColumn('{{%category}}', 'module', $moduleColumn);
        $this->createTable('{{%document_download}}', [
            'id' => $this->integer(11),
            'content' => $this->text(),
            'PRIMARY KEY (id)',
        ], $tableOptions);
        $this->createTable('{{%document_photo}}', [
            'id' => $this->integer(11),
            'PRIMARY KEY (id)',
        ], $tableOptions);
        $this->insert('{{%document_module}}', [
            'name' => 'article',
            'title' => '文章',
        ]);
        $this->insert('{{%document_module}}', [
            'name' => 'exhibition',
            'title' => '展会',
        ]);
        $this->insert('{{%document_module}}', [
            'name' => 'download',
            'title' => '下载',
        ]);
        $this->insert('{{%document_module}}', [
            'name' => 'photo',
            'title' => '相册',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%document_module}}');
        $this->dropTable('{{%document_exhibition}}');
        $this->dropTable('{{%document_download}}');
        $this->dropTable('{{%document_photo}}');
        $this->dropColumn('{{%document}}', 'module');
        $this->dropColumn('{{%category}}', 'module');
    }
}
