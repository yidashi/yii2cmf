<?php

namespace common\modules\document\models;

/**
 * This is the model class for table "{{%document_module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 */
class DocumentModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标识',
            'title' => '名称',
        ];
    }

    public static function getTypeEnum()
    {
        return self::find()->select('title')->indexBy('name')->column();
    }
}
