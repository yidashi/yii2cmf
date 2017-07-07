<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16-1-28
 * Time: 下午6:40
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\Article;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    /**
     * @api {get} /v1/articles 文章列表
     * @apiVersion 1.0.0
     * @apiName index
     * @apiGroup Article
     *
     * @apiParam {Integer} [cid] 分类ID.
     * @apiParam {String} [module]  模块类型
     *
     */
    public function actionIndex($cid = null, $module = null)
    {
        $query = Article::find()->published()
            ->andFilterWhere(['category_id' => $cid])
            ->andFilterWhere(['module' => $module]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $dataProvider;
    }
    /**
     * @api {get} /v1/articles/id:\d+ 文章内容
     * @apiVersion 1.0.0
     * @apiName view
     * @apiGroup Article
     *
     */
    public function actionView($id)
    {
        request()->setQueryParams(['expand'=>'data']);
        $model = Article::find()->published()->where(['id' => $id])->with('data')->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        $model->addView();
        return $model;
    }
}