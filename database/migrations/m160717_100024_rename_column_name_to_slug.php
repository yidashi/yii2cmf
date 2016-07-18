<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160717_100024_rename_column_name_to_slug extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%page}}', 'name', 'slug');
        $this->renameColumn('{{%category}}', 'name', 'slug');
        $this->createIndex('slug', '{{%page}}', 'slug');
        $this->createIndex('slug', '{{%category}}', 'slug');
    }

    public function down()
    {
        $this->dropIndex('slug', '{{%page}}');
        $this->dropIndex('slug', '{{%category}}');
        $this->renameColumn('{{%page}}', 'slug', 'name');
        $this->renameColumn('{{%category}}', 'slug', 'name');
    }
}
