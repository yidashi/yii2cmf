<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/11
 * Time: 下午6:13
 */

namespace plugins\danmu\controllers;

use common\components\Controller;
use common\models\Comment;
use common\modules\user\models\User;
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
        $entityId = \Yii::$app->request->post('entity_id');
        $entity = \Yii::$app->request->post('entity');
        $time = \Yii::$app->request->post('time');
        $page = \Yii::$app->request->post('page');
        $query = Comment::find()->where(['entity' => $entity, 'entity_id' => $entityId]);
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
            $isRe = preg_match('/@(\S+?)\s/', $value->content, $matches);
            $item['isRe'] = $isRe > 0;
            if ($isRe > 0) {
                $item['re_nickname'] = $matches[1];
                $reUser = User::findByUsername($matches[1]);
                $item['re_avatar'] = Url::to($reUser->getAvatar(96), true);
            }
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