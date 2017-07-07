<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suggest-index">

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'title',
                    [
                        'attribute' => 'content',
                        'options' => ['width' => '60%']
                    ],
                    'created_at:datetime',
                    [
                        'attribute' => 'user_id',
                        'value' => function($model){
                            return $model->user->username;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
