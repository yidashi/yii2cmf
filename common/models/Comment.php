<?php

namespace common\models;

use common\behaviors\VoteBehavior;
use common\models\behaviors\CommentBehavior;
use common\modules\user\behaviors\UserBehavior;
use common\modules\user\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property string $type
 * @property int $type_id
 * @property int $parent_id
 * @property int $reply_uid
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
            [['type', 'type_id', 'content'], 'required'],
            [['type_id', 'user_id', 'parent_id', 'up', 'down', 'is_top', 'parent_id', 'reply_uid'], 'integer'],
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
            'type' => '类型',
            'type_id' => '目标',
            'user_id' => '评论人',
            'content' => '内容',
            'up' => '顶',
            'down' => '踩',
            'is_top' => '是否置顶',
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
            [
                'class' => VoteBehavior::className(),
                'type' => 'comment'
            ],
            UserBehavior::className(),
            CommentBehavior::className()
        ];
    }

    /**
     * 获取所有子评论.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSons()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
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
}
