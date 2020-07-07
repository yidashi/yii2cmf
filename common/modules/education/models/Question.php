<?php

namespace common\modules\education\models;

use Yii;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $answer
 * @property integer $type
 * @property string $answer_explain
 * @property string $option_a
 * @property string $option_b
 * @property string $option_c
 * @property string $option_d
 * @property integer $course_id
 */
class Question extends \yii\db\ActiveRecord
{
    const TYPE_RADIO = 1;
    const TYPE_FILL = 2;
    const TYPE_ESSAY = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'answer', 'type', 'course_id'], 'required'],
            [['answer_explain'], 'string'],
            [['course_id'], 'integer'],
            [['name', 'answer'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'answer' => 'Answer',
            'type' => 'Type',
            'answer_explain' => 'Answer Explain',
            'course_id' => 'Course ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\education\models\query\QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\education\models\query\QuestionQuery(get_called_class());
    }
}
