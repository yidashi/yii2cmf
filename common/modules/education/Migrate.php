<?php

namespace common\modules\education;

use yii\db\Migration;

class Migrate extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%course}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
        ]);
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('问题'),
            'answer' => $this->string(255)->notNull()->comment('答案'),
            'answer_explain' => $this->text()->comment('解析'),
            'course_id' => $this->integer(11)->notNull(),
            'type' => $this->tinyInteger(1)->notNull()->comment('类型，1单选2填空3问答'),
            'option_a' => $this->string(255),
            'option_b' => $this->string(255),
            'option_c' => $this->string(255),
            'option_d' => $this->string(255),
        ]);
        //paper
        $this->createTable('{{%paper}}', [
            'id' => $this->primaryKey(),
            'course_id' => $this->integer(11)->notNull()->comment('科目'),
            'name' => $this->string(255)->notNull()->comment('试卷名称'),
            'sub_name' => $this->string(255)->notNull()->comment('试卷副标题'),
            'test_time' => $this->integer(11)->notNull()->comment('考试时间（分钟）'),
            'user_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createTable('{{%paper_question}}', [
            'id' => $this->primaryKey(),
            'paper_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
        ]);
        $this->insert('{{%course}}', [
            'name' => '语文'
        ]);
        $this->insert('{{%question}}', [
            'name' => '选择题',
            'answer' => 'A',
            'answer_explain' => '这道题只能选A',
            'course_id' => 1,
            'type' => 1,
            'option_a' => 'a选项',
            'option_b' => 'b选项',
            'option_c' => 'c选项',
            'option_d' => 'd选项',
        ]);
        $this->insert('{{%question}}', [
            'name' => '填空题',
            'answer' => 'A',
            'answer_explain' => '这道题只能选A',
            'course_id' => 1,
            'type' => 2,
        ]);
        $this->insert('{{%question}}', [
            'name' => '问答题',
            'answer' => 'A',
            'answer_explain' => '这道题只能选A',
            'course_id' => 1,
            'type' => 3,
        ]);
        $this->insert('{{%paper}}', [
            'name' => '期末考试试卷',
            'sub_name' => '期末考试副标题',
            'course_id' => 1,
            'test_time' => 100,
            'user_id' => 1,
            'created_at' => 15555555555,
            'updated_at' => 15555555555,
        ]);
        $this->insert('{{%paper_question}}', [
            'paper_id' => 1,
            'question_id' => 1
        ]);
        $this->insert('{{%paper_question}}', [
            'paper_id' => 1,
            'question_id' => 2
        ]);
        $this->insert('{{%paper_question}}', [
            'paper_id' => 1,
            'question_id' => 3
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%course}}');
        $this->dropTable('{{%question}}');
        $this->dropTable('{{%paper}}');
        $this->dropTable('{{%paper_question}}');
    }
}
