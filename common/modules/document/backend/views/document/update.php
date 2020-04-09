<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\document\models\Document */
/* @var $moduleModel yii\db\ActiveRecord */

$this->title = '更新内容';
$this->params['breadcrumbs'][] = ['label' => '内容管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新内容';
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('内容管理', ['index'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'moduleModel' => $moduleModel,
        'module' => $module
    ]) ?>

</div>
