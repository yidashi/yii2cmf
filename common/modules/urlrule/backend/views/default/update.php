<?php


/* @var $this yii\web\View */

$this->title = '修改规则';
$this->params['breadcrumbs'][] = ['label' => 'rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Rule';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>

