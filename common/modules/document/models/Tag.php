<?php

namespace common\modules\document\models;

/**
 * This is the model class for table "pop_tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $document
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
            'document' => '该标签内容数'
        ];
    }

    /**
     * 标签级别,根据热门度区分,方便前台区分颜色
     * @return string
     */
    public function getLevel()
    {
        $level = 'default';
        if ($this->document > self::LEVEL_SUCCESS && $this->document < self::LEVEL_PRIMARY) {
            $level = 'success';
        } elseif ($this->document >= self::LEVEL_PRIMARY && $this->document < self::LEVEL_DANGER) {
            $level = 'primary';
        } elseif ($this->document >= self::LEVEL_DANGER) {
            $level = 'danger';
        }
        return $level;
    }

    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['id' => 'document_id'])
            ->viaTable('{{%document_tag}}', ['tag_id' => 'id'])->published();
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
        DocumentTag::deleteAll(['tag_id' => $event->sender->id]);
    }
}
