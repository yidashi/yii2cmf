<?php


/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace backend\models;
use common\models\Attachment;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class MediaItem
{
    const TYPE_FILE = 'file';
    const TYPE_FOLDER = 'folder';

    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_VIDEO = 'video';
    const FILE_TYPE_AUDIO = 'audio';
    const FILE_TYPE_DOCUMENT = 'document';

    /**
     * @var string Specifies the item path relative to the Library root.
     */
    public $path;

    /**
     * @var integer Specifies the item size.
     * For files the item size is measured in bytes. For folders it
     * contains the number of files in the folder.
     */
    public $size;

    /**
     * @var integer Contains the last modification time (Unix timestamp).
     */
    public $lastModified;

    /**
     * @var string Specifies the item type.
     */
    public $type;

    /**
     * @var string Specifies the public URL of the item.
     */
    public $publicUrl;

    /**
     * @var array Contains a default list of files and directories to ignore.
     * The list can be customized with the following configuration options:
     * - cms.storage.media.image_extensions
     * - cms.storage.media.video_extensions
     * - cms.storage.media.audo_extensions
     */
    protected static $defaultTypeExtensions = [
        'image' => ['gif', 'png', 'jpg', 'jpeg', 'bmp'],
        'video' => ['mp4', 'avi', 'mov', 'mpg', 'mpeg', 'mkv', 'webm'],
        'audio' => ['mp3', 'wav', 'wma', 'm4a', 'ogg']
    ];

    protected static $imageExtensions;
    protected static $videoExtensions;
    protected static $audioExtensions;

    public function __construct($path, $size, $lastModified, $type, $publicUrl)
    {
        $this->path = $path;
        $this->size = $size;
        $this->lastModified = $lastModified;
        $this->type = $type;
        $this->publicUrl = $publicUrl;
    }
    /**
     *
     * @param Attachment $attachment
     */
    public static function createFromAttachment($attachment)
    {
        $item = new static($attachment->path,$attachment->size, $attachment->updated_at, 'file', $attachment->url);
        return $item;
    }

    public function isFile()
    {
        return $this->type == self::TYPE_FILE;
    }


    public function isImage()
    {
        return $this->getFileType() === self::FILE_TYPE_IMAGE;
    }

    /**
     * Returns the file type by its name.
     * The known file types are: image, video, audio, document
     * @return string Returns the file type or NULL if the item is a folder.
     */
    public function getFileType()
    {
        if (!$this->isFile()) {
            return null;
        }

        if (!self::$imageExtensions) {
            self::$imageExtensions = \Yii::$app->get("config")->get('attachment.image_extensions', self::$defaultTypeExtensions['image']);
            self::$videoExtensions = \Yii::$app->get("config")->get('attachment.video_extensions', self::$defaultTypeExtensions['video']);
            self::$audioExtensions = \Yii::$app->get("config")->get('attachment.audio_extensions', self::$defaultTypeExtensions['audio']);
        }

        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        if (!strlen($extension)) {
            return self::FILE_TYPE_DOCUMENT;
        }

        if (in_array($extension, self::$imageExtensions)) {
            return self::FILE_TYPE_IMAGE;
        }

        if (in_array($extension, self::$videoExtensions)) {
            return self::FILE_TYPE_VIDEO;
        }

        if (in_array($extension, self::$audioExtensions)) {
            return self::FILE_TYPE_AUDIO;
        }

        return self::FILE_TYPE_DOCUMENT;
    }

    /**
     * Returns the item size as string.
     * For file-type items the size is the number of bytes. For folder-type items
     * the size is the number of items contained by the item.
     * @return string Returns the size as string.
     */
    public function sizeToString()
    {
        return  \Yii::$app->getFormatter()->asShortSize($this->size);;
    }

    public function getResolution()
    {
        $size = getimagesize($this->path);

        return $size[0] . "x" . $size[1];
    }

    /**
     * Returns the item last modification date as string.
     * @return string Returns the item's last modification date as string.
     */
    public function lastModifiedAsString()
    {
        if (!$this->lastModified) {
            return null;
        }

        return  \Yii::$app->getFormatter()->asDatetime($this->lastModified);
    }
}
