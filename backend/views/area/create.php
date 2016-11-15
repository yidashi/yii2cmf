<?php


/* @var $this yii\web\View */

$this->title = 'Create Area ';
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加新区域';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>

