<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property string $content
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'user_id', 'content'], 'required'],
            [['article_id', 'user_id', 'parent_id', 'up', 'down'], 'integer'],
            [['content'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'user_id' => 'User ID',
            'content' => '内容',
            'up' => '顶',
            'down' => '踩'
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public function getSons()
    {
        return $this->hasMany(Comment::className(), ['parent_id'=>'id']);
    }

    /**
     * 绑定写入后的事件
     */
    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this,'addComment']);
    }
    public function addComment()
    {
        $article = Article::find()->where(['id' => $this->article_id])->one();
        $article->updateCounters(['comment' => 1]);
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT
        ];
    }
}
