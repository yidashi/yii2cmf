<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:59.
 */
use common\behaviors\TagBehavior;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::find()->where(['allow_publish' => 2])->select('title')->indexBy('id')->column()) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

        <?php foreach ($moduleModel->formAttributes() as $attribute): ?>
            <?= $form->field($moduleModel, $attribute)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(), ['type' => $moduleModel->getAttributeType($attribute), 'data' => $moduleModel->getAttributeItems($attribute), 'options' => $moduleModel->getAttributeOptions($attribute)]) ?>
        <?php endforeach; ?>

    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'cover')->widget(\common\modules\attachment\widgets\SingleWidget::className()) ?>

        <?= $form->field($model, TagBehavior::$formName)->label(TagBehavior::$formLable)->widget(\common\widgets\tag\TagsInput::className())?>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
