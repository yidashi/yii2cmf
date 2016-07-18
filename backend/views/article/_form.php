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
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">通用</a></li>
                <?php if ($model->moduleClass): ?>
                <li><a href="#tab_2" data-toggle="tab" aria-expanded="true">扩展</a></li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::getDropDownlist()) ?>

                    <?= $form->boxField($model, 'desc')->textarea()?>

                    <?= $form->field($model, 'content')->widget(\common\widgets\EditorWidget::className()); ?>

                </div>
                <?php if ($model->moduleClass): ?>
                <div class="tab-pane" id="tab_2">
                    <?php foreach ($model->extendAttributes() as $attribute): ?>
                        <?= $form->field($model, $attribute)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(), ['type' => $model->getAttributeType($attribute)]) ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
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

        <?= $form->field($model, 'tagNames')->widget(\common\widgets\tag\Tag::className(), [
            'clientOptions' => ['width' => '230px']
        ]) ?>

        <?= $form->field($model, 'source')->textInput() ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>