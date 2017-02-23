<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;
use yii\imagine\Image;

/**
 * This is the model class for table 'pop_attachment'.
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $title
 * @property string $path
 * @property string $extension
 * @property string $description
 * @property string $hash
 * @property integer $size
 * @property string $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $url
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'hash'], 'required'],
            [['user_id', 'size'], 'integer'],
            [['name', 'title', 'description', 'type', 'extension'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'hash' => 'Hash',
            'size' => 'Size',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ]
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'url'
        ]);
    }

    public function getUrl()
    {
        return Yii::$app->storage->getUrl($this->path);
    }

    public function getAbsolutePath()
    {
        return Yii::$app->storage->getPath($this->path);
    }

    /**
     * @return \League\Flysystem\Handler
     */
    public function getFile()
    {
        return Yii::$app->storage->fs->get($this->path);
    }

    public function getThumb($width, $height, $options = [])
    {
        $width = (int) $width;
        $height = (int) $height;

        $thumbFile = $this->getThumbFilename($width, $height, $options);
        $thumbPath = pathinfo($this->path, PATHINFO_DIRNAME) . $thumbFile;

        if (!\Yii::$app->storage->fs->has($thumbPath)) {
            $this->makeThumbStorage($thumbPath, $width, $height, $options);
        }
        return \Yii::$app->storage->getUrl($thumbPath);
    }

    // TODO 这里只能用localFilesystem
    protected function makeThumbStorage($thumbPath, $width, $height, $options)
    {
        Image::thumbnail($this->getAbsolutePath(), $width, $height)->save($thumbPath);

    }

    protected function getThumbFilename($width, $height, $options)
    {
        return 'thumb_' . $this->primaryKey . '_' . $width . 'x' . $height . '_' . $options['offset'][0] . '_' . $options['offset'][1] . '_' . $options['mode'] . '.' . $options['extension'];
    }

    protected function getDefaultThumbOptions($overrideOptions = [])
    {
        $defaultOptions = [
            'mode' => 'auto',
            'offset' => [
                0,
                0
            ],
            'quality' => 95,
            'extension' => 'jpg'
        ];

        if (! is_array($overrideOptions)) {
            $overrideOptions = [
                'mode' => $overrideOptions
            ];
        }

        $options = array_merge($defaultOptions, $overrideOptions);

        $options['mode'] = strtolower($options['mode']);

        if ((strtolower($options['extension'])) == 'auto') {
            $options['extension'] = strtolower($this->extension);
        }

        return $options;
    }

    public function deleteThumbs()
    {
        $collection = $this->getThumbs();
        if (!empty($collection)) {
            foreach ($collection as $item) {
                Yii::$app->storage->fs->delete($item);
            }
        }
    }

    public function getThumbs()
    {
        $pattern = 'thumb_' . $this->primaryKey . '_';

        $allFiles = \Yii::$app->storage->fs->listContents();

        $collection = [];
        foreach ($allFiles as $file) {
            if (StringHelper::startsWith($file['basename'], $pattern)) {
                $collection[] = $file['path'];
            }
        }
        return $collection;
    }
    public function afterDelete()
    {
        parent::afterDelete();
        // 文件删了
        if (Yii::$app->storage->fs->has($this->path)) {
            Yii::$app->storage->fs->delete($this->path);
        }
    }

}
