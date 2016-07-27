<?php

namespace common\models;
use common\behaviors\XsBehavior;
use common\models\behaviors\ArticleDataBehavior;
use yii\helpers\Markdown;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%article_data}}".
 *
 * @property int $id
 * @property string $content
 */
class ArticleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['id', 'markdown'], 'integer'],
            ['markdown', 'default', 'value' => $this->getIsMarkdown()],
            [['content'], 'string'],
        ];
    }

    /**
     * 没有指定markdown情况下默认编辑器是否为markdown
     * @return int
     */
    public function getIsMarkdown()
    {
        return \Yii::$app->config->get('EDITOR_TYPE') == 'markdown' ? 1 : 0;
    }

    public function getProcessedContent()
    {
        return $this->markdown ? \yii\helpers\Markdown::process($this->content, 'gfm') : $this->content;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'markdown' => '是否markdown格式'
        ];
    }

    public function behaviors()
    {
        $behaviors = [
            ArticleDataBehavior::className()
        ];
        if (\Yii::$app->config->get('SEARCH_ENGINE') == 'xunsearch') {
            $behaviors[] = XsBehavior::className();
        }
        return $behaviors;
    }
}
