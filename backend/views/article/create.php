<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $model common\models\Article */
/* @var $module string */

$this->title = '发表文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('文章', ['index'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataModel' => $dataModel,
        'moduleModel' => $moduleModel,
        'module' => $module
    ]) ?>

</div>
