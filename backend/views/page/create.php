<?php

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = '创建页面';
$this->params['breadcrumbs'][] = ['label' => '页面管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
