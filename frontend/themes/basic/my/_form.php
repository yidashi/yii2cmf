<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:59.
 */
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

        <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::find()->select('title')->indexBy('id')->column()) ?>

        <?= $form->field($model, 'desc')->textarea(['rows' => 5]) ?>

        <?= $form->field($model, 'content')->widget(\common\widgets\EditorWidget::className()); ?>

        <?= $form->field($model, 'tagNames')->widget(\common\widgets\tag\Tag::className())?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'cover')->widget(\common\widgets\upload\SingleWidget::className()) ?>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
