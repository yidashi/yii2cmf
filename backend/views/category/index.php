<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>

<div class="box box-primary">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id:text:ID',
                'title:html:分类名',
                'slug:text:标识',
                'article:text:文章数',
                'sort',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{create} {update} {delete}',
                    'buttons' => [
                        'create' => function($url, $model) {
                            return Html::a(Html::icon('plus'), ['create', 'id' => $model['id']], ['class' => 'btn btn-default btn-xs']);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>