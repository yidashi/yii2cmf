<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Suggest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '留言', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suggest-view">

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
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
            'content:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username
            ],
        ],
    ]) ?>

</div>
