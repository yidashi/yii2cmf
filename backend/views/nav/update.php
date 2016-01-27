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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
