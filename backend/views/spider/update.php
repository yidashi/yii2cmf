<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = 'Update Spider: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Spiders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
