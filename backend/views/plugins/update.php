<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Module */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Module',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
