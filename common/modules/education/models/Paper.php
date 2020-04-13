<?php

namespace common\modules\education\models;

use Yii;

/**
 * This is the model class for table "{{%paper}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $sub_name
 * @property integer $test_time
 * @property Question[] $questions
 */
class Paper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%paper}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'test_time'], 'required'],
            [['test_time'], 'integer'],
            [['name', 'sub_name'], 'string', 'max' => 100],
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
            'sub_name' => '副标题',
            'test_time' => 'Test Time',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\education\models\query\PaperQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\education\models\query\PaperQuery(get_called_class());
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])->via('paperQuestions');
    }

    public function getPaperQuestions()
    {
        return $this->hasMany(PaperQuestion::className(), ['paper_id' => 'id']);
    }
}
