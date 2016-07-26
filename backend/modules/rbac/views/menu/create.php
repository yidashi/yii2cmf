<?php


/* @var $this yii\web\View */
/* @var $model rbac\models\Menu */

$this->title = Yii::t('rbac', 'Create Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
