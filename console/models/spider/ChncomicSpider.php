<?php
namespace console\models\spider;

use Goutte\Client;

class ChncomicSpider extends SpiderAbstract{
    private $_url;

    /**
     * 构造方法，初始化采集网站属性
     */
    public function __construct(){
        $this->name = 'chncomic';
        $this->domain = 'http://www.chncomic.com';
        $this->category = [
            '影视'=>'http://www.chncomic.com/info/yingshi',
        ];
    }

    /**
     * 采集执行函数,调用 getPages ，获取所有分页 ；然后调用 urls ，获取每页文章的文章url，并将他们存入队列
     */
    public function process(){
        foreach($this->category as $category=>$url){
            $pages = $this->getPages($url,$category);
            if($pages){
                foreach($pages as $p){
                    $this->urls($category,$p);
                }
            }
        }
    }

    /**
     * 获取当前网站指定分类的分页
     * @return array
     */
    private function getPages($pageUrl,$category){
        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);
        //获取分页
        $crawler->filter('.page_div ul li a')->each(function ($node) use($pageUrl,$category) {
            if($node){
                try{
                    $this->_url[] = $this->domain.trim($node->attr('href'));
                }catch(\Exception $e){
                    $this->addLog($pageUrl,$category,false,$e->getMessage());
                }
            }
        });
        return array_unique($this->_url);
    }

    /**
     * 获取每页的文章列表中文章URL和发布时间
     * @param $category
     * @param $url
     */
    private function urls($category,$url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter('.info_list')->each(function ($node) use($category,$url) {
            if($node){
                try{
                    $a = $node->filter('h1 a');
                    if($a){
                        $u = trim($a->attr('href'));
                        if(!$this->isGathered($u)){
                            $this->enqueue($category,$u,$this->name);
                        }
                    }
                }catch(\Exception $e){
                    $this->addLog($url,$category,false, $e->getMessage());
                }
            }
        });
    }

    /**
     * 获取指定url的文章标题、内容、发布时间
     * @param $url
     * @param $category
     * @return string
     */
    public function getContent($url,$category){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $node = $crawler->filter('.main')->eq(0);
        if($node){
            try{
                $title = $node->filter('.w_640 h1.article_title');
                $time = $node->filter('.time span');
                $con = $node->filter('.article_con');
                if($title && $time){
                    $title = trim($title->text());
                    $content = $con->html();
                    $time = $time->text();
                    return json_encode(['title'=>$title,'content'=>$content,'time'=>$time]);
                }
            }catch(\Exception $e){
                $this->addLog($url,$category,false,$e->getMessage());
            }
        }
        return '';
    }
}