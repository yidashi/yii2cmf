<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/8/4 14:36
 * Description:
 */

namespace common\components;


use yii\db\Connection;
use yii\db\Query;

class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Executes query and returns a single row of result.
     * @param Connection|null $db the DB connection used to create the DB command.
     * If `null`, the DB connection returned by [[modelClass]] will be used.
     * @return ActiveRecord|array|null a single row of query result. Depending on the setting of [[asArray]],
     * the query result may be either an array or an ActiveRecord object. `null` will be returned
     * if the query results in nothing.
     * @throws ModelNotFountException
     */
    public function oneOrFail($db = null)
    {
        $row = Query::one($db);
        if ($row !== false) {
            $models = $this->populate([$row]);
            if (reset($models)) {
                return reset($models);
            }
        }
        throw new ModelNotFountException();
    }
}