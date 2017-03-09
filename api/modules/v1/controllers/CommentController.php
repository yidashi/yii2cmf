<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/8
 * Time: 下午11:19
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\Comment;
use yii\data\ActiveDataProvider;

class CommentController extends Controller
{
    public function actionIndex($entity, $entity_id)
    {
        $query = Comment::find()->where(['entity' => $entity, 'entity_id' => $entity_id, 'status' => 1, 'parent_id' => 0]);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'is_top' => SORT_DESC,
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }
}