<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = '更新导航: '.' '.$model->title;
$this->params['breadcrumbs'][] = ['label' => '导航', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nav-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
