<?php

namespace frontend\models;

use common\models\Category;
use yii\behaviors\BlameableBehavior;

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
class Article extends \common\models\Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'author'], 'required'],
            [['status', 'category_id', 'comment', 'user_id'], 'integer'],
            [['title', 'category'], 'string', 'max' => 50],
            [['category_id'], 'setCategory'],
            [['author', 'cover', 'desc'], 'string', 'max' => 255],
        ];
    }
    public function setCategory($attribute, $params)
    {
        $this->category = Category::find()->where(['id' => $this->category_id])->select('title')->scalar();
    }
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
                ],
            ]
        );
    }
    public static function hots($categoryId, $size = 10)
    {
        return self::find()
            ->andWhere(['category_id' => $categoryId])
            ->limit($size)
            ->orderBy('view desc')
            ->all();
    }

    /**
     * @return mixed不包括未审核通过和已删除的
     */
    public static function find()
    {
        return parent::find()->where(['deleted_at' => 0, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * @return mixed包括未审核通过的
     */
    public static function withUnactive()
    {
        return parent::find()->where(['deleted_at' => 0]);
    }
    /**
     * 增加浏览量.
     */
    public function addView()
    {
        $redis = \Yii::$app->redis;
        $rkey = 'article:view:'.$this->id;
        $rview = $redis->get($rkey);
        if (!empty($rview) && $rview >= 20) {
            // 每次查出来的时候就已经修改过view的值了,这里只需要保存!
            $this->save(false);
            $redis->set($rkey, 1);
        } else {
            $redis->incr($rkey);
        }
    }

}
