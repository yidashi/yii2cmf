<?php
namespace console\models;

class ArticleJob{
    public function perform()
    {
        //获取队列内容属性
        $args=$this->args;
        $category= $args['category'];
        $url= $args['url'];
        $baseClassName= $args['className'];
        $publishTime = $args['publishTime'];
        $spider = SpiderFactory::create($baseClassName);
        $res = $spider->getContent(trim($url),$category);
        $res = json_decode($res,true);
        if($res){
            $title = $res['title'];
            $content = $res['content'];
            $time = $res['time'];
            $time = $publishTime?:$time;
            try{
                $result = $spider->insert($title,$content,$time,$category);
                $spider->addLog($url,$category,$result,$title);
            }catch(\Exception $e){
                echo $e->getMessage().PHP_EOL;
            }
        }

    }
}