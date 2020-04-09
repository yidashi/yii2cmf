<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model common\modules\document\models\Document */
/* @var $model common\modules\document\models\Document */
/* @var $module string */

$this->title = '发布内容';
$this->params['breadcrumbs'][] = ['label' => '内容管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('内容管理', ['index'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <?= \common\widgets\SideNavWidget::widget([
                    'items' => $categories
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
