<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/8
 * Time: 下午10:46
 */

namespace console\controllers;


use common\models\Article;
use common\models\ArticleTag;
use common\models\Attachment;
use common\models\Comment;
use common\models\Tag;
use yii\base\Exception;
use yii\console\Controller;

class ScriptController extends Controller
{
    public function actionConfirmComment()
    {
        $query = Article::find();
        foreach ($query->each() as $item) {
            $comment = Comment::find()->where(['type' => 'article', 'type_id' => $item->id])->count();
            $item->comment = $comment;
            $item->save(false);
        }
    }

    public function actionDeleteAttachment()
    {
        foreach(Attachment::find()->each() as $model) {
            try {
                $file = file_get_contents($model->url);
                if (!$file) {
                    throw new Exception('文件内容未空');
                }
            } catch (\Exception $e) {
                $model->delete();
            }

        }
    }

    public function actionConfirmTag()
    {
        foreach (Tag::find()->each() as $model) {
            $count = ArticleTag::find()->where(['tag_id' => $model->id])->count();
            $model->article = $count;
            $model->save(false);
        }
    }
}