<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Nav');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('新导航', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="box box-primary">
    <div class="box-body">


<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',
        'key',
        'title',

        [
            'class' => 'backend\widgets\grid\ActionColumn',
            'template'=>'{update} {delete}'
        ],
    ],
]); ?>
    </div>
</div>
