<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航（前台)）';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-index">

    <p>
        <?= Html::a('创建导航', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'title',
            'route',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
