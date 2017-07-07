<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = '自定义css';
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="template">

<?php $form = ActiveForm::begin()?>

<?php echo $form->field($model,"text")->textarea(['rows' => 30,'cols'=>70])?>

<div class="form-group">
        <?= Html::submitButton("保存CSS", ['class' => 'btn bg-maroon btn-flat btn-block '])?>
</div>

<?php ActiveForm::end()?>

</div>