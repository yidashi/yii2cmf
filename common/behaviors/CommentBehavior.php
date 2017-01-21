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
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\validators\Validator;

class CommentBehavior  extends Behavior
{
    /**
     * @var \yii\db\ActiveRecord
     */
    public $owner;

    public $type;

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
            $model->type = $this->getType();
            $model->type_id = $this->getTypeId();
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
                $model->type = $this->getType();
                $model->type_id = $this->getTypeId();
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
        $type = $this->getType();
        $type_id = $this->getTypeId();
        CommentInfo::deleteAll(['type' => $type, 'type_id' => $type_id]);
        Comment::deleteAll(['type' => $type, 'type_id' => $type_id]);
    }

    public function getCommentInfo()
    {
        return $this->owner->hasOne(CommentInfo::className(), [
            'type_id' => $this->owner->primaryKey()[0]
        ])->where(["type" => $this->getType()]);
    }


    public function getType()
    {
        if ($this->type == null) {
            $this->type = $this->owner->className();
        }

        return ltrim($this->type,"\\");
    }

    public function getTypeId()
    {
        return $this->owner->getPrimaryKey();
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