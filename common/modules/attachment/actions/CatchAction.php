<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/3/23 18:08
 * Description:
 */

namespace common\modules\attachment\actions;


use common\modules\attachment\models\Attachment;
use yii\base\Action;

class CatchAction extends Action
{
    public $path;

    public $catcherFieldName = 'source';

    public function run()
    {
        \Yii::$app->response->format = 'json';
        $fieldName = $this->catcherFieldName;
        /* 抓取远程图片 */
        $list = array();
        $source = request($fieldName);
        foreach ($source as $imgUrl) {
            list($attachment, $error) = Attachment::uploadFromUrl($this->path, $imgUrl);
            array_push($list, [
                "state" => 'SUCCESS',
                "url" => $attachment["url"],
                "size" => $attachment["size"],
                "title" => htmlspecialchars($attachment["title"]),
                "original" => htmlspecialchars($attachment["name"]),
                "source" => htmlspecialchars($imgUrl)
            ]);
        }

        /* 返回抓取数据 */
        return [
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ];
    }
}