<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('新用户', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="box box-primary">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'id',
                'username',
                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                'email',
                 'created_at:datetime',
                 'login_at:datetime',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ]
            ],
        ]); ?>
    </div>
</div>
