<?php

namespace common\modules\schedule;

use yii\db\Migration;

/**
 * Handles the creation for table `{{%schedule}}`.
 */
class Migrate extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        //schedule
        $this->createTable('{{%schedule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('任务名称'),
            'cron' => $this->string(255)->notNull()->comment('crontab表达式'),
            'job' => $this->string(255)->notNull()->comment('命令'),
            'status' => $this->tinyInteger(255)->notNull()->comment('状态')->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%schedule}}');
    }
}
