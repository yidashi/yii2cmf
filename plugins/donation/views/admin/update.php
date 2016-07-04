<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model plugins\donation\models\Donation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Donation',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="donation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
