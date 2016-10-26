<?php

/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Spider',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spiders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="spider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
