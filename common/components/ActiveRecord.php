<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/8/4 14:33
 * Description:
 */

namespace common\components;

use Yii;
USE yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @param $condition
     * @return static|array|null
     */
    public static function findOneOrFail($condition)
    {
        return static::findByCondition($condition)->oneOrFail();
    }

    protected static function findByCondition($condition)
    {
        $query = static::find();

        if (!ArrayHelper::isAssociative($condition)) {
            // query by primary key
            $primaryKey = static::primaryKey();
            if (isset($primaryKey[0])) {
                $pk = $primaryKey[0];
                if (!empty($query->join) || !empty($query->joinWith)) {
                    $pk = static::tableName() . '.' . $pk;
                }
                $condition = [$pk => $condition];
            } else {
                throw new InvalidConfigException('"' . get_called_class() . '" must have a primary key.');
            }
        }

        return $query->andWhere($condition);
    }
}