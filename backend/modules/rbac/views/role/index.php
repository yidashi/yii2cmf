<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var rbac\models\AuthItemSearch $searchModel
 */
$this->title = Yii::t('rbac', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">


    <p>
        <?= Html::a(Yii::t('rbac', 'Create Role'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
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
                    [
                        'attribute' => 'description',
                        'label' => Yii::t('rbac', 'Description'),
                    ],
                    ['class' => 'backend\widgets\grid\ActionColumn'],
                ],
            ]);
            Pjax::end();
            ?>
        </div>
    </div>
</div>
