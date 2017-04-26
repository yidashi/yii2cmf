<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $moduleModel yii\db\ActiveRecord */

$this->title = '更新文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('发布文章', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'moduleModel' => $moduleModel,
        'module' => $module
    ]) ?>

</div>
