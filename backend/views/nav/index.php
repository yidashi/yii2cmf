<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Navs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Nav'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'slug',
                    'title',
                    'url:url',
                    'data',
                    // 'type',
                    // 'pid',
                    // 'status',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
