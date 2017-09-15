<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54.
 */
namespace frontend\controllers;

use common\models\Category;
use common\models\Article;
use common\models\Tag;
use frontend\services\ArticleService;
use frontend\services\TagService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    /**
     * 分类文章列表
     * @param mixed $cate
     * @param mixed $module
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($cate = null, $module = null)
    {
        $query = Article::find()->published();
        $category = null;
        if (!empty($cate)) {
            $category = Category::findByIdOrSlug($cate);
            if (empty($category)) {
                throw new NotFoundHttpException('分类不存在');
            }
            $query = $query->andFilterWhere(['category_id' => $category->id]);
        }
        $query->andFilterWhere(['module' => $module]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC
                ],
                'attributes' => [
                    'published_at',
                    'view'
                ]
            ]
        ]);
        // 热门标签
        $hotTags = TagService::hot();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            'hotTags' => $hotTags
        ]);
    }

    /**
     * 标签文章列表
     */
    public function actionTag($name)
    {
        /* @var $tag Tag */
        $tag = Tag::find()->where(['name' => $name])->one();
        if (empty($tag)) {
            throw new NotFoundHttpException('标签不存在');
        }
        $query = $tag->getArticles();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC
                ]
            ]
        ]);
        // 热门标签
        $hotTags = Tag::find()->orderBy('article desc')->all();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tag' => $tag,
            'hotTags' => $hotTags
        ]);
    }
    /**
     * 文章详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::find()->published()->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        $model->addView();

        // sidebar
        $hots = ArticleService::hots($model->category_id);
        // 上下一篇
        $next = Article::find()->andWhere(['>', 'id', $id])->one();
        $prev = Article::find()->andWhere(['<', 'id', $id])->orderBy('id desc')->one();
        return $this->render($model->module . '/view', [
            'model' => $model,
            'hots' => $hots,
            'next' => $next,
            'prev' => $prev
        ]);
    }
}
