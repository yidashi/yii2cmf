<?php

namespace common\models;

use common\models\behaviors\VoteBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class Vote extends \yii\db\ActiveRecord
{
    const ACTION_UP = 'up';
    const ACTION_DOWN = 'down';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vote}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'type_id'], 'required'],
            [['user_id', 'type_id'], 'integer'],
            [['type', 'action'], 'string', 'max' => 20],
            ['action', 'in', 'range' => ['up', 'down']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            VoteBehavior::className()
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'type_id']);
    }

}
