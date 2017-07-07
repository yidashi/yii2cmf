<?php

namespace common\models;

use common\behaviors\NotifyBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pop_favourite".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $article_id
 * @property integer $created_at
 */
class Favourite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favourite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id'], 'required'],
            [['user_id', 'article_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'article_id' => '文章',
            'created_at' => '收藏时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
            [
                'class' => NotifyBehavior::className(),
                'entity' => __CLASS__
            ]
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

}
