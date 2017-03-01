<?php

namespace common\modules\book\models;

use common\behaviors\CommentBehavior;
use common\behaviors\PositionBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%book_chapter}}".
 *
 * @property integer $id
 * @property integer $book_id
 * @property integer $catalog_id
 * @property integer $chapter_name
 * @property string $chapter_body
 * @property integer $pid
 * @property integer $created_at
 * @property integer $updated_at
 * @property Book $book
 */
class BookChapter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book_chapter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'chapter_name'], 'required'],
            [['book_id', 'pid'], 'integer'],
            [['chapter_name', 'chapter_body'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => '书',
            'chapter_name' => '章节标题',
            'chapter_body' => '章节正文',
            'pid' => 'Pid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort',
                'groupAttributes' => ['book_id', 'pid']
            ],
            [
                'class' => CommentBehavior::className()
            ]
        ];
    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    public function getSons()
    {
        return $this->hasMany(self::className(), ['pid' => 'id']);
    }
}
