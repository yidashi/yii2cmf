<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54.
 */
namespace common\modules\document\frontend\controllers;

use common\modules\document\models\Tag;
use common\modules\document\models\Category;
use common\modules\document\models\Document;
use common\modules\document\services\DocumentService;
use common\modules\document\services\TagService;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            /*'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['view'],
                'duration' => 60 * 60 *24 * 365,
                'variations' => [
                    \Yii::$app->request->get('id')
                ]
            ]*/
        ];
    }

    /**
     * 分类文章列表
     * @param mixed $cate
     * @param mixed $module
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($cate, $module = null)
    {
        $query = Document::find()->published();
        $category = null;
        $category = Category::findByIdOrSlug($cate);
        if (empty($category)) {
            throw new NotFoundHttpException('分类不存在');
        }
        $query = $query->andFilterWhere(['category_id' => $category->id]);
        if (empty($module)) {
            $module = $category->module;
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
        $template = $module . '/' . $category->list_template . '/index';
        return $this->render($template, [
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
        $query = $tag->getDocuments();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC
                ]
            ]
        ]);
        // 热门标签
        $hotTags = Tag::find()->orderBy('document desc')->all();
        return $this->render('tag', [
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
        $model = Document::find()->published()->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }

        // sidebar
        $hots = DocumentService::hots($model->category_id);
        // 上下一篇
        $next = Document::find()->andWhere(['>', 'id', $id])->one();
        $prev = Document::find()->andWhere(['<', 'id', $id])->orderBy('id desc')->one();
        $template = $model->module . '/' . $model->category->content_template . '/view';
        return $this->render($template, [
            'model' => $model,
            'hots' => $hots,
            'next' => $next,
            'prev' => $prev
        ]);
    }

    public function actionAddView($id)
    {
        \Yii::$app->response->format = 'raw';
        $model = Document::find()->published()->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        $model->addView();
        $trueView = $model->getTrueView();
        return "document.write({$trueView})";
    }
}
