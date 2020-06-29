<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">


    <p>
        <?= Html::a('创建标签', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'document',

                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
                ],
            ]); ?>
        </div>
    </div>

</div>
