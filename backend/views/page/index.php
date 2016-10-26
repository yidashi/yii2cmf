<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '页面管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header'); ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', '新页面'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock(); ?>
<div class="box box-primary">
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            [
                'attribute' => 'use_layout',
                'value' => function ($model) {
                    $arr = ['不使用', '使用'];
                    return $arr[$model->use_layout];
                },
            ],
            'title',
            'slug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
