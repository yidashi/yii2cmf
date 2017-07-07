<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = '添加主题';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="upload-theme row">
	<p class="install-help">如果您有.zip格式的主题，可以在这里通过上传的方式安装。</p>
	<p class="install-help">请确保压缩包名和主题名保持一致。比如:basic.zip里边是basic主题</p>

<?php $form = ActiveForm::begin(["options"=>["class"=>"wp-upload-form clearfix","enctype"=>"multipart/form-data"]])?>

<?php echo $form->field($model, "themezip",["options"=>["class"=>"pull-left"]])->fileInput()->label(false);?>

<input type="submit"
		name="install-theme-submit" id="install-theme-submit" class="button"
		value="现在安装" />
	<?php  ActiveForm::end();?>
</div>