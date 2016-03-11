<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdminLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'route',
            'description:ntext',
            'created_at:datetime',
            [
                'attribute' => 'user_id',
                'value' => \common\models\User::findOne($model->user_id)->username
            ],
            [
                'attribute' => 'ip',
                'value' => long2ip($model->ip)
            ]
        ],
    ]) ?>

</div>
