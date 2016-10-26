<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58.
 */
namespace frontend\controllers;

use common\models\Comment;
use common\modules\user\traits\AjaxValidationTrait;
use yii\base\Exception;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreate()
    {
        \Yii::$app->response->format = 'json';
        $model = new Comment();
        $model->load(\Yii::$app->request->post());
        if ($model->save()) {
            return ['message' => '评论成功'];
        } else {
            return ['status' => 0, 'message' => '评论失败'];
        }
    }
    // 图文弹幕
    public function actionDm()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $typeId = \Yii::$app->request->post('type_id');
        $type = \Yii::$app->request->post('type');
        $time = \Yii::$app->request->post('time');
        $page = \Yii::$app->request->post('page');
        $query = Comment::find()->where(['type' => $type, 'type_id' => $typeId]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->alias('comment')->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->with('user')
            ->all();
        $list = array_map(function ($value) {
            $item['id'] = $value->id;
            $item['avatar'] = Url::to($value->user->getAvatar(96), true);
            $item['nickname'] = $value->user->username;
            $item['content'] = preg_replace('/(@\S+?\s)/', '', $value->content);
            $item['isRe'] = preg_match('/(@\S+?\s)/', $value->content, $matches);
            return $item;
        }, $models);
        $hasNext = 0;
        if ($page < $pages->pageCount) {
            $hasNext = 1;
        }
        return [
            'list' => $list,
            'hasNext' => $hasNext,
            'time' => $time,
        ];
    }
}
