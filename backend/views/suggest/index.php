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
                        'template' => '{view} {delete} {ban}',
                        'buttons' => [
                            'ban' => function($url, $model, $key) {
                                return Html::a(Html::icon('ban'),
                                    ['/user/ban'],
                                    [
                                        'title' => '封禁用户',
                                        'data-method' => 'post',
                                        'data-params' => ['id' => $model->user_id],
                                        'class' => 'btn btn-default btn-xs'
                                    ]
                                );
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
