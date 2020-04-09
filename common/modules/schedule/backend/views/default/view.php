<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\modules\schedule\models\Schedule */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '任务调度', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cron',
            'job'
        ],
    ]) ?>

</div>
