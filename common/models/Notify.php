<?php

namespace common\models;

use common\components\notify\Parser;
use common\modules\book\models\Book;
use common\modules\book\models\BookChapter;
use common\modules\user\behaviors\UserBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%notify}}".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property string $content
 * @property integer $created_at
 * @property integer $category_id
 * @property string $extra
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

    public function getEntity()
    {
        $extra = Json::decode($this->extra);
        switch ($this->category_id) {
            case NotifyCategory::REWARD:
                return Html::a($extra['article_title'], ['/article/view', 'id' => $extra['article_id']]);
                break;
            case NotifyCategory::UP_ARTICLE:
                return Html::a($extra['entity_title'], ['/article/view', 'id' => $extra['entity_id']]);
                break;
            case NotifyCategory::UP_COMMENT:
                if ($extra['entity'] == 'common\\models\\Article') {
                    return Html::a($extra['comment_title'], ['/article/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']]);
                } else {
                    return Html::a($extra['comment_title'], ['/suggest/index', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']]);
                }
                break;
            case NotifyCategory::FAVOURITE:
                return Html::a($extra['entity_title'], ['/article/view', 'id' => $extra['entity_id']]);
                break;
            case NotifyCategory::COMMENT_ARTICLE:
                return Html::a($extra['entity_title'], ['/article/view', 'id' => $extra['entity_id']]);
                break;
            case NotifyCategory::COMMENT_SUGGEST:
                return Html::a($extra['entity_title'], ['/suggest/view', 'id' => $extra['entity_id']]);
                break;
            default:
                return '';
                break;
        }
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

    public function getLink()
    {
        $extra = Json::decode($this->extra);
        switch ($this->category_id) {
            case NotifyCategory::SUGGEST:
                return ['/suggest/view', 'id' => $extra['entity_id']];
                break;
            case NotifyCategory::MESSAGE:
                return ['/message/index'];
                break;
            case NotifyCategory::COMMENT_ARTICLE:
                return ['/article/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                break;
            case NotifyCategory::COMMENT_SUGGEST:
                return ['/suggest/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                break;
            case NotifyCategory::REPLY:
                if ($extra['entity'] == 'common\\models\\Article') {
                    return ['/article/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                }else if ($extra['entity'] == 'common\\modules\\book\\models\\Book') {
                    return ['/book/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                }else if ($extra['entity'] == 'common\\modules\\book\\models\\BookChapter') {
                    return ['/book/chapter', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                } else if ($extra['entity'] == 'common\\models\\Suggest') {
                    return ['/suggest/view', 'id' => $extra['entity_id'], '#' => 'comment-' . $extra['comment_id']];
                }
                break;
            default:
                return '';
                break;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            if ($this->to->isConfirmed) {
                \Yii::$app->mailer->compose()
                    ->setTo($this->to->email)
                    ->setSubject($this->from->username . ' ' . $this->getTitle())
                    ->setTextBody($this->getContent())
                    ->send();
            }

        }
    }
}
