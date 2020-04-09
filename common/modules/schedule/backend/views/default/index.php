<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务调度';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('新增任务调度', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="comment-index">
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'cron',
                    'job',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete} {run}',
                        'buttons' => [
                            'run' => function ($url, $model, $key) {
                                return Html::a('运行', $url, ['class' => 'btn btn-danger btn-xs']);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
