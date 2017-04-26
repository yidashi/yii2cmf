<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%comment_info}}".
 *
 * @property string $entity
 * @property integer $entity_id
 * @property integer $status
 * @property integer $total
 */
class CommentInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'status', 'total'], 'integer'],
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
            'status' => 'Status',
            'total' => 'Total',
        ];
    }
}
