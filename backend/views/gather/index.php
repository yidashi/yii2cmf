<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gathers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gather-index">

    <p>
        <?= Html::a('Create Gather', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'category',
            'url:url',
            'url_org:url',
            // 'res',
            // 'result',

            ['class' => 'backend\widgets\grid\ActionColumn'],
        ],
    ]); ?>

</div>
