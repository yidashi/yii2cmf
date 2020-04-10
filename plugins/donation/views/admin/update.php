<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model plugins\donation\models\Donation */

$this->title = '捐赠: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '捐赠', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="donation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
