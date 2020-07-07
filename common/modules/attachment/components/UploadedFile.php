<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/12 15:33
 * Description:
 */

namespace common\modules\attachment\components;

use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * Class UploadedFile
 * @package common\modules\attachment\components
 * @property string $hashName
 */
class UploadedFile extends \yii\web\UploadedFile
{
    public $stream;

    public function getHashName($path = null)
    {
        if ($path) {
            $path = rtrim($path, '/').'/';
        }

        $hash = \Yii::$app->security->generateRandomString(40);

        return $path.$hash.'.'.$this->getExtension();
    }

    public function store($path, $options = [])
    {
        return $this->storeAs($path, $this->getHashName(), $this->parseOptions($options));
    }

    public function storeAs($path, $name, $options = [])
    {
        $options = $this->parseOptions($options);

        $disk = ArrayHelper::remove($options, 'disk');

        return \Yii::$app->storage->disk($disk)->putFileAs(
            $path, $this, $name, $options
        );
    }

    protected function parseOptions($options)
    {
        if (is_string($options)) {
            $options = ['disk' => $options];
        }

        return $options;
    }

    public static function getInstanceByStream($stream)
    {
        $mimeType = 'image/jpeg';
        $extensions = FileHelper::getExtensionsByMimeType($mimeType);
        $extension = current($extensions);
        return new static([
            'extension' => $extension,
            'stream' => $stream,
            'type' => $mimeType,
        ]);
    }

    public function getStream()
    {
        return $this->stream ?: file_get_contents($this->tempName);
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        if ($this->extension === null) {
            $this->extension = parent::getExtension();
        }
        if (empty($this->extension)) {
            $this->extension = 'jpg';
        }
        return $this->extension;
    }
}