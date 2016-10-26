<?php

/* @var $this yii\web\View */
/* @var $model common\models\NavItem */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Nav Item',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Nav Items'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->nav->key, 'url' => ['update', 'id' => $model->nav->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="nav-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
