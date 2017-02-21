<?php

use backend\widgets\ActiveForm;
use backend\widgets\meta\MetaForm;
use yii\helpers\Html;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form backend\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'pid')->dropDownList(Category::getDropDownList(Category::lists()), ['prompt' => '请选择']) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sort')->textInput() ?>

        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

        <?= $form->field($model, 'module')->checkboxList(\common\models\ArticleModule::getTypeEnum()) ?>

        <?= $form->field($model, 'allow_publish')->radioList($model::getAllowPublishEnum()) ?>

        <?= $form->boxField($model, 'meta',["collapsed"=>true])->widget(MetaForm::className())->header("SEO"); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat btn-block' : 'btn btn-primary btn-flat btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
