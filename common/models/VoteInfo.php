<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vote_info}}".
 *
 * @property string $entity
 * @property integer $entity_id
 * @property integer $up
 * @property integer $down
 */
class VoteInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'up', 'down'], 'integer'],
            [['entity'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity' => 'Entity Class',
            'entity_id' => 'Entity ID',
            'up' => 'Up',
            'down' => 'Down',
        ];
    }
}
