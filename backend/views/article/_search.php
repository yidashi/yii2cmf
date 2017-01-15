<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use common\helpers\Tree;

/* @var $this yii\web\View */
/* @var $model backend\models\search\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php
    Yii::$container->set(\yii\widgets\ActiveField::className(), ['template' => "{label}\n{input}"]);
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getDropDownList(Tree::build(Category::lists())), ['prompt' => '全部']) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusList(), ['prompt' => '全部']) ?>

    <?= $form->field($model, 'module')->dropDownList(\common\models\ArticleModule::getTypeEnum(), ['prompt' => '全部']) ?>

    <?= Html::submitButton(Html::icon('search'), ['class' => 'btn btn-primary btn-flat']) ?>
    <div class="error-summary hide"><ul></ul></div>

    <?php ActiveForm::end(); ?>

</div>
