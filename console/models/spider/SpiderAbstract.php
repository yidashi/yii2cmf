<?php
namespace console\models\spider;

use common\models\Article;
use common\models\ArticleTag;
use common\models\Gather;
use common\models\Spider;
use common\models\Tag;
use yii\base\Exception;
use Goutte\Client;

Abstract class SpiderAbstract{
    private $_url;
    protected $config;
    /**
     * 构造方法，初始化采集网站属性
     */
    public function __construct(){
        $this->setConfig();
    }
    public function getConfig()
    {
        return $this->config;
    }
    protected function setConfig()
    {
        $className = strtolower(get_class($this));
        // 去除命名空间
        $spiderName = join('', array_slice(explode('\\', $className), -1));
        $spider = Spider::find()->where(['name'=>$spiderName])->one();
        if(empty($spider)){
            throw new Exception('不存在目标网站');
        }
        $this->config = [];
        $category = [];
        $targetCategory = explode(',', $spider->target_category);
        $targetCategoryUrl = explode(',', $spider->target_category_url);
        foreach($targetCategory as $k=>$cate){
            $category[$cate] = $targetCategoryUrl[$k];
        }
        $this->config['category'] = $category;
        $this->config['name'] = $spider->name;
        $this->config['title'] = $spider->title;
        $this->config['domain'] = $spider->domain;
        $this->config['page_dom'] = $spider->page_dom;
        $this->config['list_dom'] = $spider->list_dom;
        $this->config['title_dom'] = $spider->title_dom;
        $this->config['time_dom'] = $spider->time_dom;
        $this->config['content_dom'] = $spider->content_dom;
    }
    /**
     * 采集执行函数,调用 getPages ，获取所有分页 ；然后调用 urls ，获取每页文章的文章url，并将他们存入队列
     */
    public function process(){
        foreach($this->config['category'] as $category=>$url){
            $pages = $this->getPages($url,$category);
            if($pages){
                foreach($pages as $p){
                    $this->urls($category,$p);
                }
            }
        }
    }
    /**
     * 判断文章是否采集
     * @param $url
     * @return bool
     */
    protected function isGathered($url){
        $gather = Gather::find()->where(['url'=>md5(trim($url)),'res'=>1])->one();
        return $gather?1:0;
    }

    /**
     * 插入URL队列
     * @param $category
     * @param $url
     * @param $className
     * @param string $publishTime
     */
    public function enqueue($category,$url,$className,$publishTime=''){
        \Resque::enqueue('article_spider', 'console\models\ArticleJob',['category'=>$category,'url'=>$url,'className'=>$className,'publishTime'=>$publishTime]);
    }

    /**
     * 获取当前网站指定分类的分页
     * @return array
     */
    protected function getPages($pageUrl,$category){
        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);
//        没有分页
        if(!empty($this->config['page_dom'])){
            //获取分页
            $crawler->filter($this->config['page_dom'])->each(function ($node) use($pageUrl,$category) {
                if($node){
                    try{
                        $this->_url[] = $this->config['domain'].trim($node->attr('href'));
                    }catch(\Exception $e){
                        $this->addLog($pageUrl,$category,false,$e->getMessage());
                    }
                }
            });
        }else{
            $this->_url[] = $pageUrl;
        }
        return array_unique($this->_url);
    }

    /**
     * 获取每页的文章列表中文章URL和发布时间
     * @param $category
     * @param $url
     */
    protected function urls($category,$url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter($this->config['list_dom'])->each(function ($node) use($category,$url) {
            if($node){
                try{
                    if($node){
                        $u = strpos(trim($node->attr('href')), 'http') === false ? $this->config['domain'] . trim($node->attr('href')) : trim($node->attr('href'));
                        if(!$this->isGathered($u)){
                            $this->enqueue($category,$u,$this->config['name']);
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
        try{
            $title = $crawler->filter($this->config['title_dom']);
            $time = $crawler->filter($this->config['time_dom']);
            $con = $crawler->filter($this->config['content_dom']);
            if($title && $time){
                $title = trim($title->text());
                $content = $con->html();
                $time = strtotime($time->text()) > 0 ? strtotime($time->text()) : time();
                return json_encode(['title'=>$title,'content'=>$content,'time'=>$time]);
            }
        }catch(\Exception $e){
            $this->addLog($url,$category,false,$e->getMessage());
        }
        return '';
    }
    /**
     * 将文章插入数据库
     * @param $title
     * @param $content
     * @param $publish_at
     * @param $tag
     * @return bool
     */
    public static function insert($title,$content,$publish_at,$tag=''){
        //插入标签（搜索的分类）
        $article = new Article();
        $article->title = $title;
        $article->content = $content;
        $article->author = 'yidashi';
        $article->status = 1;
        $article->created_at = $publish_at;
        $article->updated_at = $publish_at;
        $res = $article->save(false);
        /*if($tag){
            try{
                $tagModel = Tag::find()->where(['name'=>$tag])->one();
                if(!$tagModel){
                    $tagModel = new Tag();
                    $tagModel->name = $tag;
                    $tagModel->article_count = 0;
                    $tagModel->save(false);
                }
                $articleTag = new ArticleTag();
                $articleTag->article_id = $article->id;
                $articleTag->tag_id = $tagModel->id;
                $articleTag->save(false);
            }catch(\Exception $e){
                echo $e->getMessage().PHP_EOL;
            }
        }*/
        return $res?1:0;
    }

    /**
     * 采集日志
     * @param $url
     * @param $category
     * @param $res
     * @param $result
     */
    public function addLog($url,$category,$res,$result){
        $gather = new Gather();
        $gather->name = $this->config['name'];
        $gather->category = $category;
        $gather->url = md5($url);
        $gather->url_org = $url;
        $gather->res = $res;
        $gather->result = $result;
        $gather->save(false);
    }
}
?>