<?php

namespace common\models;

use common\components\notify\Parser;
use common\modules\user\behaviors\UserBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%notify}}".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property string $content
 * @property integer $created_at
 */
class Notify extends \yii\db\ActiveRecord
{
    /* @var Parser */
    public $parser;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notify}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to_uid', 'from_uid', 'category_id'], 'required'],
            [['from_uid', 'to_uid', 'read'], 'integer'],
            [['from_uid'], 'default', 'value' => 0], // 0是系统信息
            [['extra'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'category_id' => '通知类型',
            'read' => '是否读过',
            'created_at' => 'Created At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
            UserBehavior::className()
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(NotifyCategory::className(), ['id' => 'category_id']);
    }

    public function getTitle()
    {
        $item = [
            'from' => $this->from,
            'to' => $this->to,
            'extra' => Json::decode($this->extra),
            'text' => $this->category->title
        ];
        $this->parser = new Parser();
        return $this->parser->parse($item);
    }

    public function getContent()
    {
        $item = [
            'from' => $this->from,
            'to' => $this->to,
            'extra' => Json::decode($this->extra),
            'text' => $this->category->content
        ];
        $this->parser = new Parser();
        return $this->parser->parse($item);
    }
}
