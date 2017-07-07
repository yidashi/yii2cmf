<?php


/* @var $this yii\web\View */

$this->title = 'Update Rule';
$this->params['breadcrumbs'][] = ['label' => 'rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Rule';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>

