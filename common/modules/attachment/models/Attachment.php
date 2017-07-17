<?php

namespace common\modules\attachment\models;

use common\modules\attachment\components\UploadedFile;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

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
            [['hash'], 'string', 'max' => 64],
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

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::$app->storage->getUrl($this->path);
    }


    public function getThumb($width, $height, $options = [])
    {
        $width = (int) $width;
        $height = (int) $height;
        return Yii::$app->storage->thumbnail($this->path, $width, $height);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        // 文件删了
        if (Yii::$app->storage->has($this->path)) {
            Yii::$app->storage->delete($this->path);
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
     * @param $file UploadedFile
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
//            p($file->tempName);
            if ($filePath = Yii::$app->storage->putFile($path, $file)) {
                $attachment = new static();
                $attachment->path = $filePath;
                $attachment->name = $file->hashName;
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

    /**
     * 抓取远程图片
     * @param $url
     * @return array(Attachment|null|static, string|null)
     */
    public static function uploadFromUrl($path, $url)
    {
        $hash = md5(file_get_contents($url));
        $attachment = static::findByHash($hash);
        $tempFile = Yii::getAlias('@storagePath/upload/' . $hash);
        file_put_contents($tempFile, file_get_contents($url));
        $mimeType = FileHelper::getMimeType($tempFile);
        $extension = current(FileHelper::getExtensionsByMimeType($mimeType, '@common/helpers/mimeTypes.php'));
        if (empty($attachment)) {
            $fileName = $hash . '.' . $extension;
            $filePath = ($path ? ($path . '/') : '') . $fileName;
            $fileSize = filesize($tempFile);
            if (Yii::$app->storage->put($filePath, file_get_contents($tempFile))) {
                @unlink($tempFile);
                $attachment = new static();
                $attachment->path = $filePath;
                $attachment->name = $fileName;
                $attachment->extension = $extension;
                $attachment->type = $mimeType;
                $attachment->size = $fileSize;
                $attachment->hash = $hash;
                $attachment->save();
            } else {
                return [null, '上传失败'];
            }
        }
        return [$attachment, null];
    }
    public function makeCropStorage($width, $height, $x, $y)
    {
        $url = Yii::$app->storage->crop($this->path, $width, $height, [$x, $y]);
        return self::uploadFromUrl($this->path, $url);
    }

    public function __toString()
    {
        return $this->getUrl();
    }
}
