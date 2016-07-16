<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemLog */

$this->title = 'Error #' . $model->id;
$this->params['breadcrumbs'][] = ['label' =>  '系统日志', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-log-view">

    <p>
        <?php echo Html::a('删除', ['delete', 'id'=>$model->id], ['class' => 'btn btn-danger btn-flat', 'data'=>['method'=>'post']]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level',
            'category',
            [
                'attribute' => 'log_time',
                'format' => 'datetime',
                'value' => (int) $model->log_time
            ],
            'prefix:ntext',
            [
                'attribute'=>'message',
                'format'=>'raw',
                'value'=>Html::tag('pre', $model->message, ['style'=>'white-space: pre-wrap'])
            ],
        ],
    ]) ?>

</div>
