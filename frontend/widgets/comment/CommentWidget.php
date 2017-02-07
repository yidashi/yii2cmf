<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午9:04
 */

namespace frontend\widgets\comment;


use common\models\Comment;
use frontend\models\Article;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CommentWidget extends Widget
{
    public $type = 'article';
    public $type_id;
    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;
    public $listTitle = '评论';
    public $createTitle = '发表评论';

    public function init()
    {
        parent::init();
        if (isset($this->model)) {
            $this->type = $this->model->getType();
            $this->type_id = $this->model->getPrimaryKey();
        }
    }
    public function run()
    {
        if (!isset($this->model) || $this->model->getCommentEnabled()) {
            // 评论列表
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()->andWhere(['type' => $this->type, 'type_id' => $this->type_id, 'status' => 1, 'parent_id' => 0]),
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
            if (isset($this->model)) {
                $commentTotal = $this->model->getCommentTotal();
            } else {
                $commentTotal = Comment::activeCount($this->type, $this->type_id);
            }
            // 评论框
            $commentModel = new Comment();
            $commentModel->type = $this->type;
            $commentModel->type_id = $this->type_id;

            return $this->render('index', [
                'type' => $this->type,
                'typeId' => $this->type_id,
                'commentTotal' => $commentTotal,
                'commentModel' => $commentModel,
                'dataProvider' => $dataProvider,
                'listTitle' => $this->listTitle,
                'createTitle' => $this->createTitle,
            ]);
        }
    }
}