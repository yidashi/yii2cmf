<?php

namespace common\modules\schedule\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\schedule\models\Schedule]].
 *
 * @see \common\modules\schedule\models\Schedule
 */
class ScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\schedule\models\Schedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\schedule\models\Schedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
