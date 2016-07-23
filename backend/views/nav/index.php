<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Nav');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-Nav-index">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => Yii::t('backend', 'Nav'),
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
                'class' => 'backend\widgets\grid\ActionColumn',
                'template'=>'{update} {delete}'
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>
