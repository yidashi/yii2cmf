<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%comment_info}}".
 *
 * @property string $type
 * @property integer $type_id
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
            [['type_id', 'status', 'total'], 'integer'],
            [['type'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Type',
            'type_id' => 'Type ID',
            'status' => 'Status',
            'total' => 'Total',
        ];
    }
}
