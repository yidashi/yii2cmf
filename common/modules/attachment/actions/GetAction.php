<?php
namespace common\modules\attachment\actions;

use common\modules\attachment\models\Attachment;
use common\modules\attachment\models\MediaItem;
use Yii;
use yii\base\Action;
use yii\web\Response;
class GetAction extends Action
{


    public $userId;

    /**
     *
     * @var int return type (images or files)
     */
    public $type = MediaItem::FILE_TYPE_IMAGE;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(!$this->userId) {
            $this->userId = \Yii::$app->user->id;
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $attachments  = Attachment::findAll(["user_id" => $this->userId]);

        $list = [];

        foreach ($attachments as $attachment) {

            $mediaItem = MediaItem::createFromAttachment($attachment);

            if ($mediaItem->getFileType() === MediaItem::FILE_TYPE_IMAGE) {
                $list[] = [
                    'title' => $attachment->title,
                    'thumb' => $attachment->getUrl() ,
                    'image' =>  $attachment->getUrl() ,
                ];
            } elseif ($mediaItem->getFileType() === MediaItem::FILE_TYPE_DOCUMENT) {

                $list[] = [
                    'title' => $attachment->title,
                    'name' => $attachment->title,
                    'link' =>$attachment->getUrl(),
                    'size' => $attachment->size
                ];
            } else {
                $list[] = $url;
            }
        }

        return $list;
    }
}
