<?php

use yii\db\Migration;

class m161214_071011_create_table_article_book extends Migration
{
    public function up()
    {
        $this->createTable('{{%article_book}}', [
            'id' => $this->integer(11)->unique(),
            'pid' => $this->integer(11)->defaultValue('0')->comment('父id'),
            'type' => $this->smallInteger(1)->defaultValue('0')->comment('类型0目录1主题2段落')
        ]);
        $this->insert('{{%article_module}}', [
            'name' => 'book',
            'title' => '书',
            'model' => 'common\models\ArticleBook'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%article_book}}');
    }

}
