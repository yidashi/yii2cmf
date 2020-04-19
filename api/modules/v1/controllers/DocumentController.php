<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16-1-28
 * Time: 下午6:40
 */

namespace api\modules\v1\controllers;

use api\common\components\Controller;
use api\modules\v1\models\Document;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class DocumentController extends Controller
{
    protected function authOptional()
    {
        return ['*'];
    }

    /**
     * @api {get} /v1/articles 文章列表
     * @apiVersion 1.0.0
     * @apiName index
     * @apiGroup Document
     *
     * @apiParam {Integer} [cid] 分类ID.
     * @apiParam {String} [module]  模块类型
     *
     */
    public function actionIndex($cid = null, $module = null)
    {
        $query = Document::find()->published()
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
     * @api {get} /v1/articles/id:\d+
     * @apiVersion 1.0.0
     * @apiName view
     * @apiGroup Document
     *
     */
    public function actionView($id)
    {
        request()->setQueryParams(['expand'=>'data']);
        $model = Document::find()->published()->where(['id' => $id])->with('data')->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        $model->addView();
        return $model;
    }

}