<?php

namespace jamband\schemadump\tests;

use Yii;

/**
 * DatabaseOperationsTrait trait file.
 */
trait DatabaseOperationsTrait
{
    public function createTable()
    {
        Yii::$app->db->createCommand()->createTable('user', [
        ])->execute();
    }
}
