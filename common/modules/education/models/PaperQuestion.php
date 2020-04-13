<?php

namespace common\modules\education\models;

use Yii;

/**
 * This is the model class for table "{{%paper_question}}".
 *
 * @property integer $id
 * @property integer $paper_id
 * @property integer $question_id
 * @property integer $sort
 */
class PaperQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%paper_question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paper_id', 'question_id'], 'required'],
            [['paper_id', 'question_id'], 'integer'],
            [['sort'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paper_id' => 'Paper ID',
            'question_id' => 'Question ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\education\models\query\PaperQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\education\models\query\PaperQuestionQuery(get_called_class());
    }
}
