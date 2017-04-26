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
    public function actionView($id = 0)
    {
        $model = Article::find()->published()->where(['id' => $id])->with('data')->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        $model->addView();
        return $model;
    }
}