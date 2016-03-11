<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'route',
//            'description:ntext',
            'created_at:datetime',
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return \common\models\User::findOne($model->user_id)->username;
                }
            ],
            [
                'attribute' => 'ip',
                'value' => function($model) {
                    return long2ip($model->ip);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
