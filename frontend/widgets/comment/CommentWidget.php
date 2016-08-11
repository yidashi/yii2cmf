<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午9:04
 */

namespace frontend\widgets\comment;


use frontend\models\Article;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use common\models\Comment;

class CommentWidget extends Widget
{
    public $type = 'article';
    public $type_id;
    public $listTitle = '评论';
    public $createTitle = '发表评论';

    public function run()
    {
        // 评论列表
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->andWhere(['type' => $this->type, 'type_id' => $this->type_id, 'parent_id' => 0]),
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
        $model = Article::find()->normal()->andWhere(['id' => $this->type_id])->one();
        if (is_null($model) || !$model->hasAttribute('comment') || !$model->hasProperty('comment')) {
            $comment = Comment::find()->andWhere(['type' => $this->type, 'type_id' => $this->type_id])->count();
        } else {
            $comment = $model->comment;
        }
        // 评论框
        $commentModel = new Comment();
        $commentModel->type = $this->type;
        $commentModel->type_id = $this->type_id;

        return $this->render('index', [
            'comment' => $comment,
            'commentModel' => $commentModel,
            'dataProvider' => $dataProvider,
            'listTitle' => $this->listTitle,
            'createTitle' => $this->createTitle,
        ]);
    }
}