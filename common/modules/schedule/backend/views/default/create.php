<?php


/* @var $this yii\web\View */
/* @var $model \common\modules\schedule\models\Schedule */

$this->title = '新建任务调度';
$this->params['breadcrumbs'][] = ['label' => '任务调度', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
