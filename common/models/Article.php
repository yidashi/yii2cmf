<?php

namespace common\models;

use common\behaviors\AfterFindArticleBehavior;
use common\behaviors\PushBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $cover
 */
class Article extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INIT = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'category_id', 'view', 'up', 'down', 'user_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INIT]],
            [['category_id'], 'setCategory'],
            [['title', 'category', 'author'], 'string', 'max' => 50],
            [['author', 'cover'], 'string', 'max' => 255],
        ];
    }
    public function setCategory($attribute, $params)
    {
        $this->category = Category::find()->where(['id' => $this->category_id])->select('title')->scalar();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => '标题',
            'author' => '作者',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => '状态',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            PushBehavior::className(),
            AfterFindArticleBehavior::className(),
        ];
    }

    public function getData()
    {
        return $this->hasOne(ArticleData::className(), ['id' => 'id']);
    }
}
