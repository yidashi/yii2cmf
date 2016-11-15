<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = '修改导航: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改导航';
?>
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
                            'class' => 'backend\widgets\grid\PositionColumn',
                            'attribute' => 'order',
                            'route' => '/nav-item/position'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'controller' => '/nav-item',
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
