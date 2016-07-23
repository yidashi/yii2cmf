<?php


/* @var $this yii\web\View */

$this->title = 'Update Area ';
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Area';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>

