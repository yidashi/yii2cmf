<?php

namespace common\models\document;

use common\behaviors\DynamicFormBehavior;
use common\behaviors\XsBehavior;
use common\models\Document;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%document_article}}".
 *
 * @property int $id
 * @property string $content
 * @property integer $markdown
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%document_article}}';
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
        return \Yii::$app->config->get('article_editor_type') == 'markdown' ? 1 : 0;
    }

    public function getProcessedContent()
    {
        return $this->markdown ? \yii\helpers\Markdown::process($this->content) : $this->content;
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

    public function attributeHints()
    {
        return [
            'content' => '摘要不填时默认截取内容前150个字符'
        ];
    }
    public function behaviors()
    {
        $behaviors = [];
        if (\Yii::$app->config->get('SEARCH_ENGINE') == 'xunsearch') {
            $behaviors[] = XsBehavior::className();
        }
        $behaviors[] = [
            'class' => DynamicFormBehavior::className(),
            'formAttributes' => [
                'content' => [
                    'type' => 'editor',
                    'options' => function ($model) {
                        return ['widgetOptions' => $model->isNewRecord ? ['type' => config('article_editor_type')] : ['isMarkdown' => $model->markdown]];
                    }
                ],
            ]
        ];
        return $behaviors;
    }

    // 发布新文章后（摘要为空的话根据内容生成摘要)

    public function afterSave($insert, $changedAttributes)
    {
        $document = Document::findOne(['id' => $this->id]);
        if (!empty($document)) {
            if (empty($document->description)) {
                $document->description = $this->generateDesc($this->getProcessedContent());
                $document->save();
            }
        }
    }

    // 摘要生成方式
    private function generateDesc($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags($content)), 150);
    }
}
