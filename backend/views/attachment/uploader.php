<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\attachment\assets\AttachmentUploadAsset;
use yii\helpers\Url;
use yii\web\View;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */

/* @var $this yii\web\View */
/* @var $searchModel hass\attachment\models\AttachmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model yii\db\ActiveRecord */

$this->title = "上传附件";
$this->params['breadcrumbs'][] = ['label' => '附件首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AttachmentUploadAsset::register($this);

$this->registerJs("var uploadUrl='".Url::to(["/attachment/upload/create-save",'fileparam'=>"attachments"])."'",View::POS_HEAD)
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

	<p class="max-upload-size margin-bottom">最大上传文件大小：<?php echo  ini_get("upload_max_filesize")?>,最大上传文件个数: <?php echo  ini_get("max_file_uploads")?> </p>

	<div id="media-items">


	</div>
</form>