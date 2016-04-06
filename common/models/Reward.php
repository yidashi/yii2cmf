<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pop_reward".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property integer $money
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
        return 'pop_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'user_id', 'money', 'created_at', 'updated_at'], 'required'],
            [['article_id', 'user_id', 'money', 'created_at', 'updated_at'], 'integer']
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
}
