<?php
namespace migration\models;

use yii\base\Model;

class MigrationUtility extends Model
{
    
    public $migrationName = "migration";
    
    public $migrationPath;
       
    public $tableSchemas;
    
    public $tableDatas;

    /**
     * @var string
     */
    public $tableOption = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * @return array
     */
    function rules()
    {
        return [
          [["migrationName","migrationPath","tableSchemas","tableDatas","tableOption"],'safe']
        ];
    }

    public static function getTableNames()
    {
      $tables = \Yii::$app->db->getSchema()->getTableNames('', TRUE);
      return array_combine($tables,$tables);
    }

}
