<?php

namespace common\modules\attachment\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;
use yii\imagine\Image;

/**
 * This is the model class for table '{{%attachment}}'.
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
        return Yii::$app->storage->fs->getAdapter()->applyPathPrefix($this->path);
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
        return Yii::$app->storage->thumbnail($this->path, $width, $height);
        $options = $this->getDefaultThumbOptions($options);
        $thumbFile = $this->getThumbFilename($width, $height, $options);
        $thumbPath = pathinfo($this->path, PATHINFO_DIRNAME) . '/' . $thumbFile;

        if (!\Yii::$app->storage->fs->has($thumbPath)) {
            Yii::$app->storage->thumbnail($this->path, $thumbPath, $width, $height, $options);
        }
        return \Yii::$app->storage->getUrl($thumbPath);
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

    /**
     * @param $hash
     * @return static|null
     */
    public static function findByHash($hash)
    {
        return static::findOne(['hash' => $hash]);
    }

    /**
     * @param $path
     * @param $file \yii\web\UploadedFile
     * @return Attachment|null|static
     * @throws \Exception
     */
    public static function uploadFromPost($path, $file)
    {
        $hash = md5_file($file->tempName);
        $attachment = static::findByHash($hash);
        if (empty($attachment)) {
            if ($file->extension) {
                // 用hash当文件名,方便根据文件名查找
                $file->name = $hash . '.' . $file->extension;
            }
            $filePath = ($path ? ($path . '/') : '') . $file->name;
            if (Yii::$app->storage->upload($filePath, $file->tempName)) {
                $attachment = new static();
                $attachment->path = $filePath;
                $attachment->name = $file->name;
                $attachment->extension = $file->extension;
                $attachment->type = $file->type;
                $attachment->size = $file->size;
                $attachment->hash = $hash;
                $attachment->save();
            } else {
                throw new \Exception('上传失败');
            }
        }
        return $attachment;
    }

    public function makeCropStorage($width, $height, $x, $y)
    {
        $url = Yii::$app->storage->crop($this->path, $width, $height, [$x, $y]);
        $hash = md5(file_get_contents($url));
        $attachment = static::findByHash($hash);
        if (empty($attachment)) {
            $fileName = $hash . '.' . $this->extension;
            $path = trim(pathinfo($this->path, PATHINFO_DIRNAME), '.');
            $filePath = ($path ? ($path . '/') : '') . $fileName;
            if (Yii::$app->storage->upload($filePath, $url)) {
                $attachment = new static();
                $attachment->path = $filePath;
                $attachment->name = $fileName;
                $attachment->extension = $this->extension;
                $attachment->type = $this->type;
                $attachment->size = Yii::$app->storage->fs->getSize($filePath);
                $attachment->hash = $hash;
                $attachment->save();
            } else {
                throw new \Exception('上传失败');
            }
        }
        return $attachment;
    }


    protected static $mime = array (
        //applications
        'ai'  => 'application/postscript',
        'eps'  => 'application/postscript',
        'exe'  => 'application/octet-stream',
        'doc'  => 'application/vnd.ms-word',
        'xls'  => 'application/vnd.ms-excel',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pps'  => 'application/vnd.ms-powerpoint',
        'pdf'  => 'application/pdf',
        'xml'  => 'application/xml',
        'odt'  => 'application/vnd.oasis.opendocument.text',
        'swf'  => 'application/x-shockwave-flash',
        // archives
        'gz'  => 'application/x-gzip',
        'tgz'  => 'application/x-gzip',
        'bz'  => 'application/x-bzip2',
        'bz2'  => 'application/x-bzip2',
        'tbz'  => 'application/x-bzip2',
        'zip'  => 'application/zip',
        'rar'  => 'application/x-rar',
        'tar'  => 'application/x-tar',
        '7z'  => 'application/x-7z-compressed',
        // texts
        'txt'  => 'text/plain',
        'php'  => 'text/x-php',
        'html' => 'text/html',
        'htm'  => 'text/html',
        'js'  => 'text/javascript',
        'css'  => 'text/css',
        'rtf'  => 'text/rtf',
        'rtfd' => 'text/rtfd',
        'py'  => 'text/x-python',
        'java' => 'text/x-java-source',
        'rb'  => 'text/x-ruby',
        'sh'  => 'text/x-shellscript',
        'pl'  => 'text/x-perl',
        'sql'  => 'text/x-sql',
        // images
        'bmp'  => 'image/x-ms-bmp',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'png'  => 'image/png',
        'tif'  => 'image/tiff',
        'tiff' => 'image/tiff',
        'tga'  => 'image/x-targa',
        'psd'  => 'image/vnd.adobe.photoshop',
        //audio
        'mp3'  => 'audio/mpeg',
        'mid'  => 'audio/midi',
        'ogg'  => 'audio/ogg',
        'mp4a' => 'audio/mp4',
        'wav'  => 'audio/wav',
        'wma'  => 'audio/x-ms-wma',
        // video
        'avi'  => 'video/x-msvideo',
        'dv'  => 'video/x-dv',
        'mp4'  => 'video/mp4',
        'mpeg' => 'video/mpeg',
        'mpg'  => 'video/mpeg',
        'mov'  => 'video/quicktime',
        'wm'  => 'video/x-ms-wmv',
        'flv'  => 'video/x-flv',
        'mkv'  => 'video/x-matroska'
    );

    public function __toString()
    {
        return $this->getUrl();
    }
}
