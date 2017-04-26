<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '回收站';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <p>
        <?= Html::a('清空回收站', ['clear'], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'ajax' => 1,
                'confirm' => '确定要清空吗?',
            ]
        ]) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'title',
                    'category',
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            $arr = [0 => Html::icon('clock-o'), 1 => Html::icon('check'), 10 => Html::icon('times')];
                            return $arr[$model->status];
                        },
                        'format' => 'raw'
                    ],
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
                                    'data-refresh' => '1'
                                ]);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('清除',['hard-delete'], [
                                    'data-ajax' => 1,
                                    'data-confirm' => '确定要彻底删除吗？不可恢复！',
                                    'data-params' => ['id' => $model->id],
                                    'data-method' => 'post',
                                    'data-refresh' => '1'
                                ]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
