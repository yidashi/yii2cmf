<?php

/*
 * @var yii\web\View $this
 * @var rbac\models\AuthItem $model
 */
$this->title = Yii::t('rbac', 'Update Rule').': '.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Rules'), 'url' => ['index']];
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
