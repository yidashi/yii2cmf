<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleModule */

$this->title = 'Update Article Module: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
