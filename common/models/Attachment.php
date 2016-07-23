<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pop_attachment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $hash
 * @property integer $size
 * @property string $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'hash'], 'required'],
            [['user_id', 'size'], 'integer'],
            [['name', 'title', 'description', 'type', 'extension'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'hash' => 'Hash',
            'size' => 'Size',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ]
        ];
    }

    public function getFilePath()
    {
        return Yii::$app->storage->basePath . DIRECTORY_SEPARATOR . $this->name;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        // 文件删了
        $filePath = $this->getFilePath();
        @unlink($filePath);
    }
}
