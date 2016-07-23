<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Carousel',
]) . ' ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Carousels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="widget-carousel-update">
    <div class="row">
        <div class="col-md-4">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
        <div class="col-md-8">
    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'Carousel Item',
        ]), ['/carousel-item/create', 'carousel_id'=>$model->id], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $carouselItemsProvider,
        'columns' => [
            'order',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->image ? Html::img($model->image, ['width'=>200, 'height' => 100]) : null;
                }
            ],
            'url',
            [
                'format' => 'html',
                'attribute' => 'caption',
                'options' => ['style' => 'width: 20%']
            ],
            'status',

            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'controller' => '/carousel-item',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>
