<?php

use common\helpers\Html;
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
                        'class' => 'backend\widgets\grid\ActionColumn',
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
