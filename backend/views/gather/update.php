<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gather */

$this->title = 'Update Gather: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gathers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gather-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
