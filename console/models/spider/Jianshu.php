<?php
namespace console\models\spider;
class Jianshu extends SpiderAbstract{
    protected function filterContent($content='')
    {
//                只要需要的内容
//        preg_match('#([\s\S]*?)<div class=\"jiathis_style_32x32\"#', $content, $match);
//        $content = $match[1];
//                图片全路径
        $content = preg_replace('#<img([\s\S]+?)src=\"(.*?)\?.*?\"[\s\S]*?>([\s\S]*?<div class=\"image-caption\">.*?</div>)?#', '', $content);
//                去除链接
        $content = preg_replace('#<a([\s\S]+?)>(.*)?</a>#', '$2', $content);
        return $content;
    }
    protected function getCover($listNode)
    {
        $cover = strpos($listNode->parents('li')->filter('img')->attr('src'), 'http') === false ? $this->config['domain'] . $listNode->parents('li')->filter('img')->attr('src') : $listNode->parents('li')->filter('img')->attr('src');
        $coverCon = file_get_contents($cover);
        $coverPath = \Yii::getAlias('@staticroot') . '/';
        $coverFile = 'upload/image/' . date('Ymd') . '/' . time().mt_rand(100000,999999) . '.jpg';
        file_put_contents($coverPath . $coverFile,$coverCon);
        return  $coverFile;
    }
}