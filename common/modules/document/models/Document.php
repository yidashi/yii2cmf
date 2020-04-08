<?php

namespace common\modules\document\models;

use common\behaviors\MetaBehavior;
use common\behaviors\PushBehavior;
use common\behaviors\SoftDeleteBehavior;
use common\behaviors\TagBehavior;
use common\behaviors\VoteBehavior;
use common\models\Favourite;
use common\modules\attachment\behaviors\UploadBehavior;
use common\modules\document\behaviors\CategoryBehavior;
use common\modules\document\models\query\DocumentQuery;
use common\modules\user\behaviors\UserBehavior;
use Yii;
use yii\base\InvalidParamException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%document}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $category_id
 * @property string $cover
 * @property string $source
 * @property string $description
 * @property int $view
 * @property int $published_at
 * @property int $is_top
 * @property int $is_best
 * @property int $is_hot
 * @property string $module
 * @property boolean $isUp read-only
 * @property boolean $isDown read-only
 * @property boolean $isFavourite read-only
 * @property Category $category
 */
class Document extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%document}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['title'], 'trim'],
            [['status', 'category_id', 'view', 'is_top', 'is_hot', 'is_best'], 'integer'],
            ['published_at', 'default', 'value' => function(){
                return date('Y-m-d H:i:s', time());
            }],
            ['published_at', 'filter', 'filter' => function($value) {
                return is_numeric($value) ? $value : strtotime($value);
            }, 'skipOnEmpty' => true],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_PENDING]],
            ['category_id', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 50],
            [['source'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['category_id', 'status', 'view'], 'filter', 'filter' => 'intval'],
            ['module', 'string'],
            ['cover', 'safe']
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => '待审',
            self::STATUS_ACTIVE => '通过',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => '标题',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_at' => '删除时间',
            'published_at' => '发布时间',
            'status' => '状态',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
            'source' => '来源连接',
            'view' => '浏览量',
            'trueView' => '浏览量',
            'description' => '摘要',
            'tagNames' => '标签',
            'user_id' => '作者',
            'is_top' => '置顶',
            'is_hot' => '热门',
            'is_best' => '精华',
            'module' => '内容模型',
            'content' => '内容'
        ];
    }
    public function attributeHints()
    {
        return [
            'tagNames' => '（空格分隔多个标签）'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = [
            TimestampBehavior::className(),
            PushBehavior::className(),
            [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'deleted_at' => function ($model) {return time();}
                ],
                'restoreAttributeValues' => [
                    'deleted_at' => null
                ],
                'invokeDeleteEvents' => false // 不触发删除相关事件
            ],
            CategoryBehavior::className(),
            [
                'class' => MetaBehavior::className(),
                'entity' => __CLASS__
            ],
            [
                'class' => VoteBehavior::className(),
                'entity' => __CLASS__
            ],
            TagBehavior::className(),
            [
                'class' => CommentBehavior::className(),
                'entity' => __CLASS__
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'cover',
                'entity' => __CLASS__
            ],
            UserBehavior::className()
        ];
        if (!Yii::$app->request->isConsoleRequest) {
            $behaviors[] = [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ];
        }
        return $behaviors;
    }

    /**
     * @inheritdoc
     * @return DocumentQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(DocumentQuery::className(), [get_called_class()]);
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();
        // 删除文章内容
        $content = $this->data;
        if ($content != null) {
            $content->delete();
        }
    }

    public function getMetaData()
    {
        $model =  $this->getMetaModel();

        $title = $model->title ? : $this->title;
        $keywords = $model->keywords ? : $this->getTagNames(',');
        $description =$model->description ? : $this->description;

        return [$title, $keywords, $description];
    }

    public function getData()
    {
        $moduleClass = $this->findModuleClass($this->module);
        return $this->hasOne($moduleClass, ['id' => 'id']);
    }

    /**
     * 真实浏览量
     */
    public function getTrueView()
    {
        return $this->view + \Yii::$app->cache->get('article:view:' . $this->id);
    }

    /**
     * 增加浏览量
     */
    public function addView()
    {
        $cache = \Yii::$app->cache;
        $key = 'article:view:'.$this->id;
        $view = $cache->get($key);
        if ($view !== false) {
            if ($view >= 20) {
                $this->updateCounters(['view' => $view + 1]);
                $cache->delete($key);
            } else {
                $cache->set($key, ++$view);
            }
        } else {
            $cache->set($key, 1);
        }
    }

    /**
     * 当前用户是否收藏
     * @return bool
     */
    public function getIsFavourite()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $favourite = Favourite::find()->where(['document_id' => $this->id, 'user_id' => $userId])->one();
            if ($favourite) {
                return true;
            }
        }
        return false;
    }

    public function getIsReprint()
    {
        return !empty($this->source);
    }

    public function findModuleClass()
    {
        $class = new \ReflectionClass(get_called_class());
        $moduleClass = $class->getNamespaceName() . '\\document\\' . ucfirst($this->module);

        // 找父类
        if (!class_exists($moduleClass)) {
            $parentClass = $class->getParentClass();
            $moduleClass = $parentClass->getNamespaceName() . '\\document\\' . ucfirst($this->module);
        }
        if (!class_exists($moduleClass)) {
            throw new InvalidParamException('内容模型不存在');
        }
        return $moduleClass;
    }
}
