<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('新建分类', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>

<div class="box box-primary">
    <div class="box-body">
        <?= \backend\widgets\grid\TreeGrid::widget([
            'dataProvider' => $dataProvider,
            'keyColumnName' => 'id',
            'parentColumnName' => 'pid',
            'parentRootValue' => 0, //first parentId value
            'pluginOptions' => [
                'initialState' => 'expanded',
            ],
            'columns' => [
                'title',
                'slug',
                'article',
                [
                    'attribute' => 'module',
                    'value' => function($model) {
                        return $model->renderModule();
                    }
                ],
                [
                    'class' => 'backend\widgets\grid\PositionColumn',
                    'attribute' => 'sort'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{create} {view} {update} {delete}',
                    'buttons' => [
                        'create' => function($url, $model, $key) {
                            return Html::a('<i class="fa fa-plus"></i>', ['create', 'id' => $model->id], ['class' => 'btn btn-xs btn-default', 'data-toggle' => 'tooltip', 'title' => '添加子分类']);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>