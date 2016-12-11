<?php

use backend\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'model-form'
    ]
]);
?>

<?= $form->field($model,"title") ?>

<?= $form->field($model,"slug") ?>

<?= $form->field($model,"cache")->checkbox() ?>

<?=$form->field($model, 'template')->label(false)->widget(\common\widgets\EditorWidget::className(), ['isMarkdown' => 0]);?>
	<?=Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block' ])?>
<?php ActiveForm::end();?>