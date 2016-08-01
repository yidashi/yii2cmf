<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', '新用户'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="box box-primary">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                'id',
                'username',
                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                'email',
                // 'status',
                 'created_at:datetime',
                 'login_at:datetime',

                [
                    'class' => 'backend\widgets\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ]
            ],
        ]); ?>
    </div>
</div>
