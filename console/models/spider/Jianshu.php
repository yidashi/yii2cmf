<?php

namespace console\models\spider;

class Jianshu extends SpiderAbstract
{
    protected function filterContent($content = '')
    {
        //                图片全路径
        $content = preg_replace('#<img([\s\S]+?)src=\"(.*?)\?.*?\"[\s\S]*?>([\s\S]*?<div class=\"image-caption\">.*?</div>)?#', '', $content);
//                去除链接
        $content = preg_replace('#<a([\s\S]+?)>(.*)?</a>#', '$2', $content);

        return $content;
    }
    protected function getCover($listNode)
    {
        $cover = strpos($listNode->parents('li')->filter('img')->attr('src'), 'http') === false ? $this->config['domain'].$listNode->parents('li')->filter('img')->attr('src') : $listNode->parents('li')->filter('img')->attr('src');
        $coverCon = file_get_contents($cover);
        $coverRootPath = \Yii::getAlias('@staticroot').'/';
        $coverFilePath = 'upload/image/'.date('Ymd').'/';
        $coverFileName = time().mt_rand(100000, 999999).'.jpg';
        if (!is_dir($coverRootPath.$coverFilePath)) {
            mkdir($coverRootPath.$coverFilePath, 0777, true);
        }
        file_put_contents($coverRootPath.$coverFilePath.$coverFileName, $coverCon);
        @chmod($coverRootPath.$coverFilePath, 0777);

        return  $coverFilePath.$coverFileName;
    }
}
