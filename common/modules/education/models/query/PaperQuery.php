<?php

namespace common\modules\education\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\education\models\Paper]].
 *
 * @see \common\modules\education\models\Paper
 */
class PaperQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\education\models\Paper[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\education\models\Paper|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
