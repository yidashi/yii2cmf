<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Nav',
]) . ' ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="widget-Nav-update">
    <div class="row">
        <div class="col-md-4">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
        <div class="col-md-8">
        <p>
                <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
                    'modelClass' => 'Nav Item',
                ]), ['/nav-item/create', 'nav_id'=>$model->id], ['class' => 'btn btn-success btn-flat']) ?>
            </p>
            <div class="box box-primary">
                <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $navItemsProvider,
                'columns' => [
                    'title',
                    'url',
                    [
                        'class' => 'yii2tech\admin\grid\PositionColumn',
                        'attribute' => 'order',
                        'route' => '/nav-item/position'
                    ],
                    [
                        'class' => 'backend\widgets\grid\ActionColumn',
                        'controller' => '/nav-item',
                        'template' => '{update} {delete}'
                    ],
                ],
            ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
