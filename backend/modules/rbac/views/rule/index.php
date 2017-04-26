<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var rbac\models\AuthItemSearch $searchModel
 */
$this->title = Yii::t('rbac', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', '新规则'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="box box-primary">
    <div class="box-body">
    <?php
    Pjax::begin([
        'enablePushState' => false,
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac', 'Name'),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    Pjax::end();
    ?>
    </div>
</div>
