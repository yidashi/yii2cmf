<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;

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
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => $articleModuleItems
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?= $this->render('_form', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'module' => $module
        ]) ?>
    </div>
</div>
