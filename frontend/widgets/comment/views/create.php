<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model common\models\Article */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="article-create">

<!--    <h4>--><?//= $createTitle ?><!--</h4>-->

    <?php $form = ActiveForm::begin(['action' => Url::to(['/comment/create'])]); ?>
    <?= $form->field($model, 'content')->label(false)->widget(\common\widgets\editormd\Editormd::className(), ['mode' => 'mini']); ?>
    <?= $form->field($model, 'entity')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'entity_id')->hiddenInput()->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('发射', [
            'class' => 'btn btn-primary',
            'data-ajax' => '1',
            'data-refresh-pjax-container' => 'comment-container'
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <!--回复-->
    <?php $form = ActiveForm::begin(['action' => Url::to(['/comment/create']), 'options' => ['class' => 'reply-form hidden']]); ?>
    <?= $form->field($model, 'entity')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'entity_id')->hiddenInput()->label(false) ?>
    <?= Html::hiddenInput(Html::getInputName($model, 'parent_id'), 0, ['class' => 'parent_id']) ?>
    <?=$form->field($model, 'content')->label(false)->textarea()?>
    <div class="form-group">
        <?= Html::submitButton('回复', [
            'class' => 'btn btn-sm btn-primary',
            'data-ajax' => '1',
            'data-refresh-pjax-container' => 'comment-container'
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
