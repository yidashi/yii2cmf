<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/19
 * Time: 下午4:20
 */

namespace common\behaviors;

use common\models\Comment;
use common\models\CommentInfo;
use common\traits\EntityTrait;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\validators\Validator;

class CommentBehavior  extends Behavior
{
    use EntityTrait;
    /**
     * @var \yii\db\ActiveRecord
     */
    public $owner;

    public $defaultStatus = 1;

    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'addRules',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function addRules()
    {
        $this->addRule('commentEnabled', 'in', ['range' => [0, 1]]);
    }

    public function addRule($attributes, $validator, $options = [])
    {
        $validators = $this->owner->getValidators();
        $validators->append(Validator::createValidator($validator, $this->owner, (array) $attributes, $options));
    }

    public function afterInsert()
    {
        if ($this->_commentEnabled != null) {
            $status = $this->_commentEnabled;
            if ($status == $this->defaultStatus) {
                return;
            }
            $model = new CommentInfo();
            $model->entity = $this->getEntity();
            $model->entity_id = $this->getEntityId();
            $model->status = $status;
            $model->save();
        }
    }

    public function afterUpdate()
    {
        if ($this->_commentEnabled != null) {
            $status = $this->_commentEnabled;

            /* @var $model \common\models\CommentInfo */
            $model = $this->owner->commentInfo;
            if ($model == null) {
                if ($status == $this->defaultStatus) {
                    return;
                }
                $model = new CommentInfo();
                $model->entity = $this->getEntity();
                $model->entity_id = $this->getEntityId();
                $model->status = $status;
                $model->save();
            } else {
                $model->status = $status;
                $model->save();
            }
        }
    }

    public function afterDelete()
    {
        $entity = $this->getEntity();
        $entityId = $this->getEntityId();
        CommentInfo::deleteAll(['entity' => $entity, 'entity_id' => $entityId]);
        Comment::deleteAll(['entity' => $entity, 'entity_id' => $entityId]);
    }

    public function getCommentInfo()
    {
        return $this->owner->hasOne(CommentInfo::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])->where(['entity' => $this->getEntity()]);
    }

    public function getCommentTotal()
    {
        $model = $this->owner->commentInfo;
        if ($model == null) {
            return 0;
        }
        return $model->total;
    }

    private $_commentEnabled;
    public function getCommentEnabled()
    {
        if ($this->_commentEnabled != null) {
            return $this->_commentEnabled;
        }
        $model = $this->owner->commentInfo;

        if ($model == null || $model->status === null) {
            return $this->defaultStatus;
        }
        return $model->status;
    }

    public function setCommentEnabled($commentEnabled)
    {
        $this->_commentEnabled = $commentEnabled;
    }
}