<?php


/* @var $this yii\web\View */
/* @var $model \common\modules\schedule\models\Schedule */

$this->title = '修改任务调度: '.' '.$model->id;
$this->params['breadcrumbs'][] = ['label' => '任务调度', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="config-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
