<?php

namespace console\models\spider;

class Tiejiong extends SpiderAbstract
{
    protected function filterContent($content = '')
    {
        //                只要需要的内容
        preg_match('#([\s\S]*?)<div class=\"jiathis_style_32x32\"#', $content, $match);
        $content = $match[1];
//                图片全路径
        $content = preg_replace('#<img([\s\S]+?)src=\"(.*?)\"#', '<img$1src="'.$this->config['domain'].'$2"', $content);
//                去除链接
        $content = preg_replace('#<a([\s\S]+?)>(.*)?</a>#', '$2', $content);

        return $content;
    }
    protected function getCover($listNode)
    {
        $cover = strpos($listNode->filter('img')->attr('src'), 'http') === false ? $this->config['domain'].$listNode->filter('img')->attr('src') : $listNode->filter('img')->attr('src');

        return  $cover;
    }
}
