<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/12 15:33
 * Description:
 */

namespace common\modules\attachment\components;

use yii\helpers\ArrayHelper;

/**
 * Class UploadedFile
 * @package common\modules\attachment\components
 * @property string $hashName
 */
class UploadedFile extends \yii\web\UploadedFile
{

    public function getHashName($path = null)
    {
        if ($path) {
            $path = rtrim($path, '/').'/';
        }

        $hash = self::random(40);

        return $path.$hash.'.'.$this->getExtension();
    }

    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
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
}