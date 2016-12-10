<?php

namespace common\models;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "pop_spider".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $domain
 * @property string $page_dom
 * @property string $list_dom
 * @property string $time_dom
 * @property string $content_dom
 * @property string $title_dom
 * @property string $target_category
 * @property string $target_category_url
 */
class Spider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'domain', 'page_dom', 'list_dom', 'content_dom', 'title_dom', 'target_category', 'target_category_url'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['domain', 'page_dom', 'list_dom', 'time_dom', 'content_dom', 'title_dom', 'target_category', 'target_category_url'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标识',
            'title' => '名称',
            'domain' => '域名',
            'page_dom' => 'page dom',
            'list_dom' => 'List Dom',
            'time_dom' => 'Time Dom',
            'content_dom' => 'Content Dom',
            'title_dom' => 'Title Dom',
            'target_category' => '目标分类',
            'target_category_url' => '目标分类地址',
        ];
    }

    public function crawl()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $spider = $this;
        $client = new Client();
        $crawler = $client->request('get', $spider->target_category_url);
        $category = Category::findOne(['title' => $spider->target_category]);
        if ($category == null) {
            $category = new Category();
            $category->slug = $spider->target_category;
            $category->title = $spider->target_category;
            $category->save();
        }
        $crawler->filter($spider->list_dom)->each(function (Crawler $node) use ($spider, $client, $category) {
            try {
                $contentUrl = $node->attr('href');
                $gather = Gather::findOne(['url_org' => md5($contentUrl)]);
                if ($gather !== null) {
                    return;
                }
                $contentCrawler = $client->request('get', $contentUrl);
                $title = $contentCrawler->filter($spider->title_dom)->text();
                $content = $contentCrawler->filter($spider->content_dom)->html();
                $content = preg_replace_callback('/<img[\s\S]*?src="([\s\S]*?)"[\s\S]*?>/', function ($matches) {
                    if (!empty($matches[1])) {
                        $imgDir = Yii::$app->storage->basePath . '/' . date('Ymd');
                        if (!is_dir($imgDir)) {
                            FileHelper::createDirectory($imgDir);
                        }
                        $imgPath = $imgDir . '/' . time() . mt_rand(1000, 9999) . '.jpg';
                        file_put_contents($imgPath, file_get_contents($matches[1]));
                        return Html::img(Yii::$app->storage->path2url($imgPath));
                    }
                }, $content);
                $article = new Article();
                $article->title = $title;
                $article->status = Article::STATUS_ACTIVE;
                $article->category_id = $category->id;
                $article->source = $spider->domain;
                $article->save();
                $articleData = new ArticleData();
                $articleData->content = $content;
                $articleData->markdown = 0;
                $article->link('data', $articleData);
                $gather = new Gather();
                $gather->url_org = md5($contentUrl);
                $gather->save(false);
            } catch (\Exception $e) {

            }
        });
        $transaction->commit();
    }
}
