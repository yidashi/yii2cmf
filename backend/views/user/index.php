<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建新用户', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [

                    'id',
                    'username',
                    // 'auth_key',
                    // 'password_hash',
                    // 'password_reset_token',
                    'email',
                    // 'status',
                     'created_at:datetime',
                     'login_at:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {assign}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                                    'update',
                                    'id' => $model->id,
                                ], [
                                    'title' => Yii::t('yii', 'Update'),
                                    'aria-label' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                ]);
                            },
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [
                                    'view',
                                    'id' => $model->id,
                                ], [
                                    'title' => Yii::t('yii', 'View'),
                                    'aria-label' => Yii::t('yii', 'View'),
                                    'data-pjax' => '0',
                                ]);
                            },
                            'assign' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-hand-left"></span>', [
                                    '/admin/assignment/view',
                                    'id' => $model->id,
                                ], [
                                    'title' => '分配',
                                    'aria-label' => '分配',
                                    'data-pjax' => '0',
                                ]);
                            },
                        ],
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>
