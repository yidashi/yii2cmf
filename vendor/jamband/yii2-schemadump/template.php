<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */
echo "<?php\n";
?>

use yii\db\Schema;
use jamband\schemadump\Migration;

class <?= $className ?> extends Migration
{
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
}
