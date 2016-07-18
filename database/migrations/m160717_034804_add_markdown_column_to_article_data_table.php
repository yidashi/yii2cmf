<?php

use yii\db\Migration;

/**
 * Handles adding markdown to table `{{%article_data}}`.
 */
class m160717_034804_add_markdown_column_to_article_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%article_data}}', 'markdown', $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否markdown格式'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%article_data}}', 'markdown');
    }
}
