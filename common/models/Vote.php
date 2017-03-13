<?php

namespace common\models;

use common\behaviors\NotifyBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property int $id
 * @property string $entity
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $action
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
            [['entity', 'user_id', 'entity_id'], 'required'],
            [['user_id', 'entity_id'], 'integer'],
            [['entity', 'action'], 'string', 'max' => 80],
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
            'entity' => 'entity',
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
            [
                'class' => NotifyBehavior::className(),
                'entity' => __CLASS__
            ]
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'entity_id']);
    }

}
