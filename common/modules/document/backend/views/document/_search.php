<?php

use common\helpers\Tree;
use common\modules\document\models\Category;
use common\modules\document\models\Document;
use yii\helpers\Html;
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\DocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-3">
        <?= $form->field($model, 'id') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'category_id')->dropDownList(Category::getDropDownList(Tree::build(Category::lists())), ['prompt' => '全部']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'title') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(Document::getStatusList(), ['prompt' => '全部']) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('重置', ['index'], ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
