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
    /**
     * @api {get} /v1/comments 评论列表
     * @apiVersion 1.0.0
     * @apiName index
     * @apiGroup Comment
     *
     * @apiParam {Integer} entity_id 实体ID.
     * @apiParam {String} entity  实体
     *
     */
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