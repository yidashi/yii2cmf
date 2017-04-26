<?php

namespace console\models\spider;

class Fzn extends SpiderAbstract
{
    protected function filterContent($content = '')
    {
        preg_match('#([\s\S]*?)<p>转载请注明#', $content, $match);
        $content = $match[1];
        $content = preg_replace('#<a([\s\S]+?)>(.*)?</a>#', '$2', $content);

        return $content;
    }
    protected function getCover($listNode)
    {
        $cover = strpos($listNode->parents('.excerpt')->filter('img')->attr('src'), 'http') === false ? $this->config['domain'].$listNode->parents('.excerpt')->filter('img')->attr('src') : $listNode->parents('.excerpt')->filter('img')->attr('src');

        return $cover;
    }
}
