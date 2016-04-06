<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '回收站';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <p>
        <?= Html::a('清空回收站', ['clear'], [
            'class' => 'btn btn-danger',
            'data' => [
                'ajax' => 1,
                'confirm' => '确定要清空吗?',
            ]
        ]) ?>
    </p>
    <div class="box box-success">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'title',
                    'category',
                    'status:boolean',
                    // 'author',
                    // 'created_at',
                     'deleted_at:datetime',
                    // 'status',
                    // 'cover',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a('还原',['reduction'], [
                                    'data-ajax' => 1,
                                    'data-method' => 'post',
                                    'data-params' => ['id' => $model->id],
                                ]);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('清除',['hard-delete'], [
                                    'data-params' => ['id' => $model->id],
                                    'data-method' => 'post',
                                    'data-ajax' => 1,
                                ]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
