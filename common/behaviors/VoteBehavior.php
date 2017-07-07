<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/23
 * Time: 下午9:00
 */

namespace common\behaviors;


use common\models\Vote;
use common\models\VoteInfo;
use common\traits\EntityTrait;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class VoteBehavior extends Behavior
{
    use EntityTrait;
    /**
     * @var \yii\db\ActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function getVoteModel()
    {

    }

    /**
     * 当前用户是否顶
     * @return bool
     */
    public function getIsUp()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $up = Vote::find()->where(['entity' => $this->entity, 'entity_id' => $this->owner->id, 'user_id' => $userId, 'action' => Vote::ACTION_UP])->one();
            if ($up) {
                return true;
            }
        }
        return false;
    }

    /**
     * 当前用户是否踩
     * @return bool
     */
    public function getIsDown()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $down = Vote::find()->where(['entity' => $this->entity, 'entity_id' => $this->owner->id, 'user_id' => $userId, 'action' => Vote::ACTION_DOWN])->one();
            if ($down) {
                return true;
            }
        }
        return false;
    }

    public function getVoteInfo()
    {
        return $this->owner->hasOne(VoteInfo::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])->where(['entity' => $this->getEntity()]);
    }

    public function getUpTotal()
    {
        $model = $this->owner->voteInfo;
        if ($model == null) {
            return 0;
        }
        return $model->up;
    }

    public function getDownTotal()
    {
        $model = $this->owner->voteInfo;
        if ($model == null) {
            return 0;
        }
        return $model->down;
    }

    public function afterInsert()
    {
        $model = new VoteInfo();
        $model->entity = $this->getEntity();
        $model->entity_id = $this->getEntityId();
        $model->save();
    }

    public function afterUpdate()
    {
        /* @var $model \common\models\VoteInfo */
        $model = $this->owner->VoteInfo;
        if ($model == null) {
            $model = new VoteInfo();
            $model->entity = $this->getEntity();
            $model->entity_id = $this->getEntityId();
            $model->save();
        }
    }

    public function afterDelete()
    {
        $entity = $this->getEntity();
        $entityId = $this->getEntityId();
        VoteInfo::deleteAll(['entity' => $entity, 'entity_id' => $entityId]);
        Vote::deleteAll(['entity' => $entity, 'entity_id' => $entityId]);
    }
}