<?php

/* @var $this yii\web\View */
/* @var $model common\models\NavItem */

$this->title = '更新导航项' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '导航', 'url' => ['/nav/index']];
$this->params['breadcrumbs'][] = ['label' => $model->nav->key, 'url' => ['update', 'id' => $model->nav->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="nav-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
