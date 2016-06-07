<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string $content
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
            [['type_id', 'user_id', 'parent_id', 'up', 'down'], 'integer'],
            [['content'], 'string'],
        ];
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
            ]
        ];
    }

    /**
     * 获取发表评论的用户信息.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'user_id']);
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
    /**
     * 绑定写入后的事件.
     */
    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'updateComment'], ['comment' => 1]);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'updateComment'], ['comment' => -1]);
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * 更新文章评论计数器等.
     */
    public function updateComment($event)
    {
        if ($event->sender->type == 'article') {
            $article = Article::find()->where(['id' => $this->type_id])->one();
            $article->updateCounters(['comment' => $event->data['comment']]);
        }
        // 如果是回复,发站内信,通知什么的
        if ($event->sender->parent_id > 0) {
            $toUid = $event->sender->parent->user_id;
            $content = 'xxx回复了你的评论';
            Yii::$app->message->setTo($toUid)
                ->setContent($content)
                ->send();
        }
    }

    public function getIsUp()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $up = Vote::find()->where(['type' => 'comment', 'type_id' => $this->id, 'user_id' => $userId, 'action' => 'up'])->one();
            if (!empty($up)) {
                return true;
            }
        }
        return false;
    }

    public function getIsDown()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $down = Vote::find()->where(['type' => 'comment', 'type_id' => $this->id, 'user_id' => $userId, 'action' => 'down'])->one();
            if (!empty($down)) {
                return true;
            }
        }
        return false;
    }
}
