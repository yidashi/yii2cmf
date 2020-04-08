<?php

use backend\widgets\ActiveForm;
use backend\widgets\meta\MetaForm;
use common\modules\document\models\Category;
use common\modules\document\models\DocumentModule;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Category */
/* @var $form backend\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">通用</a></li>
        <li><a href="#tab_2" data-toggle="tab" aria-expanded="true">扩展</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?= $form->field($model, 'pid')->dropDownList(Category::getDropDownList(Category::lists()), ['prompt' => '请选择']) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort')->textInput() ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'module')->dropDownList(DocumentModule::getTypeEnum(), ['prompt' => '请选择']) ?>
        </div>

        <div class="tab-pane" id="tab_2">
            <?= $form->field($model, 'list_template')->textInput() ?>

            <?= $form->field($model, 'content_template')->textInput() ?>

            <?= $form->field($model, 'allow_publish')->radioList($model::getAllowPublishEnum()) ?>

            <?= $form->boxField($model, 'meta', ["collapsed" => true])->widget(MetaForm::className())->header("SEO"); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat btn-block' : 'btn btn-primary btn-flat btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>
