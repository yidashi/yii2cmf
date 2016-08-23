<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use backend\widgets\meta\MetaForm;
use common\widgets\tag\TagsInput;
use common\behaviors\TagBehavior;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $dataModel common\models\ArticleData */
/* @var $moduleModel common\models\ArticleModuleContract */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">通用</a></li>
                <?php if ($moduleModel): ?>
                <li><a href="#tab_2" data-toggle="tab" aria-expanded="true">扩展</a></li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::getDropDownlist()) ?>

                    <?= $form->boxField($model, 'description')->textarea()?>

                    <?= $form->field($dataModel, 'content')->widget(\common\widgets\EditorWidget::className(), ['type' => $dataModel->markdown ? 'markdown' : null]); ?>

                    <?= $form->boxField($model, 'meta',["collapsed"=>true])->widget(MetaForm::className())->header("SEO"); ?>
                </div>
                <?php if ($moduleModel): ?>
                <div class="tab-pane" id="tab_2">
                    <?php foreach ($moduleModel->formAttributes() as $attribute): ?>
                        <?= $form->field($moduleModel, $attribute)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(), ['type' => $moduleModel->getAttributeType($attribute)]) ?>
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
                'options' => [
                    'value' => !empty($model->published_at) ? date('Y-m-d H:i:s', $model->published_at) : ''
                ]
            ]
        ) ?>
        <?= $form->boxField($model, 'cover', ['collapsed' => true])->widget(\common\widgets\upload\SingleWidget::className()) ?>

        <?= $form->field($model, 'is_top')->checkbox() ?>

        <?= $form->field($model, 'is_hot')->checkbox() ?>

        <?= $form->field($model, 'is_best')->checkbox() ?>

        <?= $form->field($model, 'status')->checkbox() ?>

        <?= $form->field($model, 'view')->textInput() ?>

        <?= $form->boxField($model, TagBehavior::$formName)->widget(TagsInput::className())->header(TagBehavior::$formLable); ?>

        <?= $form->field($model, 'source')->textInput() ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>