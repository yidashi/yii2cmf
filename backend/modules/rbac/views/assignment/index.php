<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel rbac\models\searchs\Assignment */

$this->title = Yii::t('rbac', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">
    <p>
        <?= Html::a(Yii::t('rbac', 'Create User'), ['/user/create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?php
            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => $usernameField,
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                                '/user/update',
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
                                    'title' => Yii::t('rbac', 'Assigned'),
                                    'aria-label' => Yii::t('rbac', 'Assigned'),
                                    'data-pjax' => '0',
                                ]);
                            },
                        ],
                    ],
                ],
            ]);
            Pjax::end();
            ?>
        </div>
    </div>
</div>
