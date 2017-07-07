<?php

namespace console\models\spider;

use common\models\Article;
use common\models\ArticleData;
use common\models\Category;
use common\models\Gather;
use common\models\Spider;
use yii\base\Exception;
use Goutte\Client;
use yii\base\Object;

class SpiderAbstract extends Object
{
    public $spiderName = '';
    private $_url;
    protected $config;
    /**
     * 构造方法，初始化采集网站属性.
     */
    public function init()
    {
        $this->setConfig();
    }
    public function getConfig()
    {
        return $this->config;
    }
    protected function setConfig()
    {
        if (empty($this->spiderName)) {
            $className = strtolower(get_class($this));
            // 去除命名空间
            $this->spiderName = implode('', array_slice(explode('\\', $className), -1));
        }
        $this->config = \Yii::$app->cache->get($this->spiderName.'Config');
        if ($this->config === false) {
            $spider = Spider::find()->where(['name' => $this->spiderName])->one();
            if (empty($spider)) {
                throw new Exception('不存在目标网站');
            }
            $this->config = [];
            $category = [];
            $targetCategory = explode(',', $spider->target_category);
            $targetCategoryUrl = explode(',', $spider->target_category_url);
            foreach ($targetCategory as $k => $cate) {
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
            \Yii::$app->cache->set($this->spiderName.'Config', $this->config);
        }
    }
    /**
     * 采集执行函数,调用 getPages ，获取所有分页 ；然后调用 urls ，获取每页文章的文章url，并将他们存入队列.
     */
    public function process()
    {
        foreach ($this->config['category'] as $category => $url) {
            $pages = $this->getPages($url, $category);
            if ($pages) {
                foreach ($pages as $p) {
                    $this->urls($category, $p);
                }
            }
        }
    }
    /**
     * 判断文章是否采集.
     *
     * @param $url
     *
     * @return bool
     */
    public function isGathered($url)
    {
        $gather = Gather::find()->where(['url' => md5(trim($url)), 'res' => 1])->one();

        return $gather ? 1 : 0;
    }

    /**
     * 插入URL队列.
     *
     * @param $category
     * @param $url
     * @param $className
     * @param string $publishTime
     */
    public function enqueue($category, $url, $cover, $className, $publishTime = '')
    {
        \Resque::enqueue('article_spider', 'console\models\ArticleJob', ['category' => $category, 'url' => $url, 'className' => $className, 'publishTime' => $publishTime, 'cover' => $cover]);
    }

    /**
     * 获取当前网站指定分类的分页.
     *
     * @return array
     */
    protected function getPages($pageUrl, $category)
    {
        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);
//        没有分页
        if (!empty($this->config['page_dom'])) {
            //获取分页
            $crawler->filter($this->config['page_dom'])->each(function ($node) use ($pageUrl,$category) {
                if ($node) {
                    try {
                        $this->_url[] = strpos($node->attr('href'), '/') === 0 ? $this->config['domain']. trim($node->attr('href')) : $pageUrl.trim($node->attr('href'));
                    } catch (\Exception $e) {
                        $this->addLog($pageUrl, $category, 0, $e->getMessage());
                    }
                }
            });
        } else {
            $this->_url[] = $pageUrl;
        }

        return array_unique($this->_url);
    }

    /**
     * 获取每页的文章列表中文章URL和发布时间.
     *
     * @param $category
     * @param $url
     */
    protected function urls($category, $url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter($this->config['list_dom'])->each(function ($node) use ($category,$url) {
            if ($node) {
                try {
                    $u = strpos(trim($node->attr('href')), 'http') === false ? $this->config['domain'].trim($node->attr('href')) : trim($node->attr('href'));
                    if (method_exists($this, 'getCover')) {
                        $cover = $this->getCover($node);
                    } else {
                        $cover = '';
                    }
                    echo $this->isGathered($u);
                    if (!$this->isGathered($u)) {
                        $this->enqueue($category, $u, $cover, $this->config['name']);
                    }
                } catch (\Exception $e) {
                    $this->addLog($url, $category, 0, $e->getMessage());
                }
            }
        });
    }

    /**
     * 获取指定url的文章标题、内容、发布时间.
     *
     * @param $url
     * @param $category
     *
     * @return string
     */
    public function getContent($url, $category)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        try {
            $title = $crawler->filter($this->config['title_dom']);
            $time = $crawler->filter($this->config['time_dom']);
            $con = $crawler->filter($this->config['content_dom']);
            if ($title && $con) {
                $title = trim($title->text());
                $content = $con->html();
                if (method_exists($this, 'filterContent')) {
                    $content = $this->filterContent($content);
                }
                $time = strtotime($time->text()) > 0 ? strtotime($time->text()) : time();

                return json_encode(['title' => $title, 'content' => $content, 'time' => $time]);
            }
        } catch (\Exception $e) {
            $this->addLog($url, $category, 0, $e->getMessage());
        }

        return '';
    }

    /**
     * 将文章插入数据库.
     *
     * @param $title 标题
     * @param $content 内容
     * @param $publish_at 发布时间
     * @param string $category 分类名
     * @param string $cover    封面
     *
     * @return int
     */
    public function insert($title, $content, $publish_at, $category = '', $cover = '')
    {
        //插入标签（搜索的分类）
        $categoryId = Category::getIdByName($category);
        if (!$categoryId) {
            throw new Exception('该分类不存在');
        }
        $article = new Article();
        $article->title = $title;
        $article->status = 1;
        $article->category = $category;
        $article->category_id = $categoryId;
        $article->source = $this->config['domain'];
        $article->cover = $cover;
        $article->created_at = $publish_at;
        $article->user_id = 1;
        $res = $article->save(false);
        if ($res) {
            $articleData = new ArticleData();
            $articleData->id = $article->id;
            $articleData->content = $content;
            $res = $articleData->save(false);
        }

        return $res ? 1 : 0;
    }

    /**
     * 采集日志.
     *
     * @param $url
     * @param $category
     * @param $res
     * @param $result
     */
    public function addLog($url, $category, $res, $result)
    {
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
