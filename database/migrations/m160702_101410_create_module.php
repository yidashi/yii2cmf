<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%module}}`.
 */
class m160702_101410_create_module extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique()->comment('标识'),
            'title' => $this->string(50)->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
            'author' => $this->string(50)->comment('作者'),
            'desc' => $this->string(255)->comment('说明'),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
        ]);
        $this->batchInsert('{{%module}}', ['name', 'title', 'author', 'desc', 'status', 'created_at', 'updated_at'], [
            ['code', '获取源码', '易大师', '获取源码模块', 1, 1467461511, 1467461511],
            ['donation', '捐赠', '易大师', '捐赠模块', 1, 1467461511, 1467461511],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%module}}');
    }
}
