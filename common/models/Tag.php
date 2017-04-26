<?php

namespace common\models;

/**
 * This is the model class for table "pop_tag".
 *
 * @property integer $id
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{
    CONST LEVEL_SUCCESS = 1;
    CONST LEVEL_PRIMARY = 3;
    CONST LEVEL_DANGER = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标签名',
            'article' => '该标签文章数'
        ];
    }

    /**
     * 标签级别,根据热门度区分,方便前台区分颜色
     * @return string
     */
    public function getLevel()
    {
        $level = 'default';
        if ($this->article > self::LEVEL_SUCCESS && $this->article < self::LEVEL_PRIMARY) {
            $level = 'success';
        } elseif ($this->article >= self::LEVEL_PRIMARY && $this->article < self::LEVEL_DANGER) {
            $level = 'primary';
        } elseif ($this->article >= self::LEVEL_DANGER) {
            $level = 'danger';
        }
        return $level;
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('{{%article_tag}}', ['tag_id' => 'id'])->published();
    }

    public function init()
    {
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'afterDeleteInternal']);
    }


    /**
     * 删除标签后把拥有该标签的文章也取消掉该标签
     * @param $event
     */
    public function afterDeleteInternal($event)
    {
        ArticleTag::deleteAll(['tag_id' => $event->sender->id]);
    }
}
