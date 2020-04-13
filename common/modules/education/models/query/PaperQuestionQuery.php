<?php

namespace common\modules\education\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\education\models\PaperQuestion]].
 *
 * @see \common\modules\education\models\PaperQuestion
 */
class PaperQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\education\models\PaperQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\education\models\PaperQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
