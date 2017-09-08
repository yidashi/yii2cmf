<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "pop_reward".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property integer $money
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 */
class Reward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reward}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'money'], 'required'],
            [['article_id', 'money'], 'integer'],
            ['comment', 'string', 'max' => 50],
            ['money', 'compare', 'operator' => '>', 'compareValue' => 0]
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
            'money' => 'Money',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

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

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

}
