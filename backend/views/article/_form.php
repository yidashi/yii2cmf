<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleForm */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">附加内容</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::getDropDownlist()) ?>

                    <?= $form->boxField($model, 'desc')->textarea()?>

                    <?= $form->field($model, 'content')->widget(\common\widgets\EditorWidget::className()); ?>

                </div>
                <div class="tab-pane" id="tab_2">

                    <?= $form->field($model, 'tagNames')->widget(\common\widgets\tag\Tag::className()) ?>

                    <?= $form->field($model, 'source')->widget(\common\widgets\upload\FileWidget::className()) ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
        </div>

        <?= $form->field($model, 'published_at')->widget(
            \kartik\datetime\DateTimePicker::className(),
            [
                'type' => 1,
                'convertFormat' => true,
                'pluginOptions' => ['format' => 'php:Y-m-d H:i:s']
            ]
        ) ?>
        <?= $form->boxField($model, 'cover')->widget(\common\widgets\upload\SingleWidget::className()) ?>

        <?= $form->field($model, 'is_top')->checkbox() ?>

        <?= $form->field($model, 'status')->radioList(\common\models\Article::getStatusList()) ?>

        <?= $form->field($model, 'view')->textInput() ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>