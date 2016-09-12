<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/9/12
 * Time: 上午10:36
 */
$this->title = '相册';
?>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?= $form->field($model, 'attachmentUrls')->widget(\common\widgets\upload\MultipleWidget::className(), [
    'maxNumberOfFiles' => 10
]) ?>
<?= \yii\helpers\Html::submitButton('提交', [
    'class' => 'btn bg-maroon btn-flat btn-block'
]) ?>
<?php \yii\widgets\ActiveForm::end() ?>

