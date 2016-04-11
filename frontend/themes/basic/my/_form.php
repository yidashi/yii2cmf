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


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::find()->select('title')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'cover')->widget('yidashi\webuploader\Webuploader') ?>

    <?= $form->field($dataModel, 'content')->widget(\yidashi\markdown\Markdown::className(), ['options' => ['style' => 'height:500px;']]); ?>

    <?= $form->field($model, 'tagNames')->widget(\common\widgets\tag\Tag::className())?>

    <div class="form-group">
        <?= Html::submitButton('投稿', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
