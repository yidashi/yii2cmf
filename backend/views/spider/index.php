<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Spiders');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', 'Create Spider'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'title',
                    'domain',
                    'target_category',
//                     'target_category_url',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete} {crawl}',
                        'buttons' => [
                            'crawl' => function($url, $model, $key) {
                                return Html::a('采集', $url, ['data-method' => 'post', 'data-ajax' => 1, 'class' => 'btn btn-default btn-xs']);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
