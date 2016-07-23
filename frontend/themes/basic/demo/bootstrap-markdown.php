<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午12:05
 */
$this->title = 'markdown编辑器';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?= $form->field($model, 'content')->label('内容')->widget(\yidashi\markdown\Markdown::className(), ['useUploadImage' => true]) ?>
<?= \yii\helpers\Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
<?php \yii\widgets\ActiveForm::end() ?>
