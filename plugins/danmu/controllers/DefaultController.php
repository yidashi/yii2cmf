<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/11
 * Time: 下午6:13
 */

namespace plugins\danmu\controllers;

use common\components\WebController as Controller;
use common\models\Comment;
use yii\data\Pagination;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use Yii;

class DefaultController extends Controller
{
    // 图文弹幕
    public function actionIndex()
    {
        Yii::$app->response->format = 'json';
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
            $item['content'] = HtmlPurifier::process(preg_replace('/(@\S+?\s)/', '', $value->content));
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