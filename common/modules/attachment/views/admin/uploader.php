<?php

use common\modules\attachment\assets\AttachmentUploadAsset;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model yii\db\ActiveRecord */

$this->title = "上传附件";
$this->params['breadcrumbs'][] = ['label' => '附件首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AttachmentUploadAsset::register($this);

$this->registerJs("var uploadUrl='".Url::to(["/attachment/upload/backend-files-upload",'fileparam'=>"attachments"])."'",View::POS_HEAD)
?>

<form action="" class="media-upload-form">

	<div id="plupload-upload-ui" class="margin-bottom drag-drop">
		<div id="drag-drop-area" style="position: relative;">
			<div class="drag-drop-inside">
				<p class="drag-drop-info">将文件拖到这里</p>
				<p>或</p>

			</div>

			<div id="plupload-browse-button" class="upload-kit-input">
				<input type="button" value="选择文件"
					class="btn bg-navy btn-flat margin" />

					<input type="file"
					name="attachments[]" id="uploadFileInput" multiple="multiple" />
			 </div>

			</div>

	</div>

	<p class="max-upload-size margin-bottom">最大上传文件大小：<?= ini_get("upload_max_filesize") ?>,最大上传文件个数: <?= ini_get("max_file_uploads") ?> </p>

	<div id="media-items">


	</div>
</form>