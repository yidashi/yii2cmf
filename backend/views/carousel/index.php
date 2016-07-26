<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Carousel');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-index">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => Yii::t('backend', 'Carousel'),
            ]), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'key',
            [
                'class' => 'backend\widgets\grid\SwitcherColumn',
                'attribute' => 'status',
                'reload' => 0
            ],
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template'=>'{update} {delete}'
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>
