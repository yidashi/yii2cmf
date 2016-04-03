<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php
    Yii::$container->set(\yii\widgets\ActiveField::className(), ['template' => "{label}\n{input}\n{hint}"]);
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'category_id')->dropDownList(array_merge(['' => '全部'], \common\models\Category::find()->select('title')->indexBy('id')->column())) ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php  echo $form->field($model, 'status')->dropDownList(['' => '全部', '待审核', '正常']) ?>

    <?php // echo $form->field($model, 'cover') ?>

    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    <div class="error-summary hide"><ul></ul></div>

    <?php ActiveForm::end(); ?>

</div>
