<?php


/* @var $this yii\web\View */
/* @var $model rbac\models\Menu */

$this->title = Yii::t('rbac', 'Update Menu').': '.' '.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rbac', 'Update');
?>
<div class="menu-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
