<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:59.
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\behaviors\TagBehavior;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $dataModel common\models\ArticleData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::find()->select('title')->indexBy('id')->column()) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

        <?= $form->field($dataModel, 'content')->widget(\common\widgets\EditorWidget::className(), ['type' => $dataModel->markdown ? 'markdown' : null]); ?>

    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'cover')->widget(\common\widgets\upload\SingleWidget::className()) ?>

        <?= $form->field($model, TagBehavior::$formName)->label(TagBehavior::$formLable)->widget(\common\widgets\tag\TagsInput::className())?>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
