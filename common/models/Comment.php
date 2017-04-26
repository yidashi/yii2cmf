<?php

namespace common\models;

use common\behaviors\NotifyBehavior;
use common\behaviors\VoteBehavior;
use common\modules\user\behaviors\UserBehavior;
use common\modules\user\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use common\behaviors\UserBehaviorBehavior;
use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_ip
 * @property string $content
 * @property string $entity
 * @property int $entity_id
 * @property int $parent_id
 * @property int $reply_uid
 * @property Comment $parent
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id', 'content'], 'required'],
            [['entity_id', 'user_id', 'parent_id', 'is_top', 'parent_id', 'reply_uid'], 'integer'],
            [['content'], 'string'],
            ['parent_id', function($attribute){
                $this->reply_uid = $this->parent->user_id;
            }],
            ['content', 'setReplyUid'],
        ];
    }

    public function setReplyUid($attribute)
    {
        if (preg_match('/@(\S+?)\s/', $this->$attribute, $matches) > 0) {
            $replyUserName = $matches[1];
            $replyUserId = User::find()->select('id')->where(['username' => $replyUserName])->scalar();
            $this->reply_uid = $replyUserId;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => '类型',
            'entity_id' => '目标',
            'user_id' => '评论人',
            'user_ip' => 'IP',
            'content' => '内容',
            'up' => '顶',
            'down' => '踩',
            'is_top' => '是否置顶',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'parent_id' => '父评论'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ],
            VoteBehavior::className(),
            UserBehavior::className(),
            [
                'class' => NotifyBehavior::className(),
                'entity' => __CLASS__
            ],
            [
                'class' => UserBehaviorBehavior::className(),
                'eventName' => [self::EVENT_AFTER_INSERT],
                'name' => 'comment',
                'rule' => [
                    'cycle' => 24,
                    'max' => 10,
                    'counter' => 5,
                ],
                'content' => '{user.username}在{extra.time}评论',
                'data' => [
                    'extra' => [
                        'time' => date('Y-m-d H:i:s')
                    ]
                ]
            ]
        ];
    }

    /**
     * 获取所有子评论.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSons()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])->where(['status' => 1]);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function process($data)
    {
        preg_match('/@(\S+?)\s/', $data, $matches);
        if (!empty($matches)) {
            $replyUserName = $matches[1];
            $replyUserId = User::find()->select('id')->where(['username' => $replyUserName])->scalar();
            $data = preg_replace('/(@\S+?\s)/', Html::a('$1', ['/user/default/index', 'id' => $replyUserId]), $data);
        }
        return $data;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert == true) {
                $this->user_ip = Yii::$app->getRequest()->getUserIP();
                return true;
            }

            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->updateCommentTotal();
            return true;
        }

        return true;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->updateCommentTotal();
    }

    public function updateCommentTotal()
    {
        $model = CommentInfo::find()->where(['entity' => $this->entity, 'entity_id' => $this->entity_id])->one();
        $total = Comment::activeCount($this->entity, $this->entity_id);
        if($model == null && $total != 0) {
            $model = new CommentInfo();
            $model->entity =$this->entity;
            $model->entity_id = $this->entity_id;
            $model->total =$total;
            $model->save();
        } else {
            $model->total = $total;
            $model->save();
        }
    }

    public static function activeCount($entity, $entity_id = NULL)
    {
        return self::find()->where([
            'entity' => $entity,
            'entity_id' => $entity_id,
            'status' => 1
        ])->count();
    }
}
