<?php
use yii\helpers\Html;
$labelOptions = [
    'class' => 'control-label'
];
$inputOptions = [
    'class' => 'form-control'
];

?>
<div class="form-group">
	<?= Html::activeLabel($model, 'title', $labelOptions)?>
	<?= Html::activeTextInput($model, 'title', $inputOptions)?>
</div>
<div class="form-group">
	<?= Html::activeLabel($model, 'keywords', $labelOptions)?>
	<?= Html::activeTextInput($model, 'keywords', $inputOptions)?>
</div>
<div class="form-group">
	<?= Html::activeLabel($model, 'description', $labelOptions)?>
	<?= Html::activeTextarea($model, 'description', $inputOptions)?>
</div>