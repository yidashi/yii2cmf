<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">附加内容</a></li>
    </ul>
    <?php $form = ActiveForm::begin([
            'options' => ['class' => 'tab-content'],
        ]); ?>
        <div class="tab-pane active" id="tab_1">

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::getDropDownlist()) ?>

            <?= $form->field($model, 'content')->widget(\yidashi\markdown\Markdown::className(), ['options' => ['style' => 'height:500px']]) ?>

            <?= $form->field($model, 'cover')->widget(\iisns\webuploader\Cropper::className()) ?>

            <?= $form->field($model, 'status')->radioList(\common\models\Article::getStatusList()) ?>

        </div>
        <div class="tab-pane" id="tab_2">
            <?= $form->field($model, 'is_top')->checkbox() ?>

            <?= $form->field($model, 'published_at')->widget(
                \kartik\datetime\DateTimePicker::className(),
                [
                    'type' => 1,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d H:i:s']
                ]
            ) ?>
            <?= $form->field($model, 'desc')->textarea()?>

            <?= $form->field($model, 'tagNames')->widget(\common\widgets\tag\Tag::className()) ?>

            <?= $form->field($model, 'source')->textInput() ?>

            <?= $form->field($model, 'view')->textInput() ?>

        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>