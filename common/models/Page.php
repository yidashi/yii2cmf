<?php

namespace common\models;
use common\behaviors\CommentBehavior;
use common\behaviors\MetaBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property int $use_layout
 * @property string $content
 * @property string $title
 * @property integer $markdown
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'title', 'slug'], 'required'],
            [['content'], 'string'],
            ['markdown', 'default', 'value' => $this->getIsMarkdown()],
            [['use_layout'], 'in', 'range' => [0, 1]],
            [['title'], 'string', 'max' => 50],
            ['content', 'filterHtml']
        ];
    }

    public function filterHtml($attribute)
    {
        $this->$attribute = HtmlPurifier::process($this->$attribute, function ($config) {
            $config->set('HTML.Allowed', 'p[style],a[href|title],img[src|title|alt|class],h3,ul,ol,li,span,b,strong,hr,code,table,tbody,tr,td');
            // 清除空标签
            $config->set('AutoFormat.RemoveEmpty', true);
        });
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
            'use_layout' => '是否使用布局',
            'content' => '内容',
            'title' => '标题',
            'slug' => '标识'
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => '（影响url）'
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => MetaBehavior::className(),
            ],
            [
                'class' => CommentBehavior::className()
            ]
        ];
    }

    public function getMetaData()
    {
        $model = $this->getMetaModel();

        $title = $model->title ?  : $this->title;

        $description = $model->description ?  : StringHelper::truncate(strip_tags($this->content), 150);

        return [$title, $description, $model->keywords];
    }
}
