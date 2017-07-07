<?php


/* @var $this yii\web\View */
/* @var $model rbac\models\AuthItem */

$this->title = Yii::t('rbac', 'Update Permission').': '.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac', 'Update');
?>
<div class="auth-item-update">

	<?php
    echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
