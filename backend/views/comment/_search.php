<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use common\helpers\Tree;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-header"><h2 class="box-title">搜索</h2></div>
    <div class="box-body">
            <?php
            Yii::$container->set(\yii\widgets\ActiveField::className(), ['template' => "{label}\n{input}"]);
            $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'form-inline'],
            ]); ?>

            <?= $form->field($model, 'entity')->dropDownList(\common\helpers\Util::getEntityList(), ['prompt' => '请选择']) ?>
            <?= $form->field($model, 'entity_id') ?>

            <?= Html::submitButton(Html::icon('search'), ['class' => 'btn btn-primary btn-flat']) ?>
            <div class="error-summary hide"><ul></ul></div>

            <?php ActiveForm::end(); ?>

    </div>
</div>
