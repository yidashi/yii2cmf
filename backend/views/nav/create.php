<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = '创建导航';
$this->params['breadcrumbs'][] = ['label' => '导航', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
