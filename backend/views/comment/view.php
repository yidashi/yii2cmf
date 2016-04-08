<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'article_id',
            'content:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'parent_id',
            'up',
            'down',
        ],
    ]) ?>

</div>
