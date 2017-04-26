<?php

use common\modules\attachment\widgets\AvatarUploadAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 *
 * @var yii\web\View $this
 */
AvatarUploadAsset::register($this);

$this->registerJs("var uploadUrl='" . Url::to([
    "/attachment/upload/avatar-upload",
    'fileparam' => "avatar"
]) . "'", View::POS_HEAD);

$this->title = '头像设置';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container user-module">
	<div class="row">
		<div class="col-md-3">
            <?= $this->render('../_menu')?>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?= Html::encode($this->title)?>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<div id="upload-avatar-wrapper">
								<div class="avatar-item">
									<?php echo Html::img($user->getAvatar(200),["class"=>"avatar-uploader"])?>
								</div>
								<input type="hidden" name="cx" id="crop-x" /> <input
									type="hidden" name="cy" id="crop-y" /> <input type="hidden"
									name="cw" id="crop-w" /> <input type="hidden" name="ch"
									id="crop-h" />
							</div>
							<div class="row">
								<div class="col-md-6">
									<div id="plupload-browse-button" class="upload-kit-input">
										<input type="button" value="上传头像"
											class="btn btn-danger btn-block" /> <input type="file"
											name="avatar" id="uploadFileInput" multiple="multiple" />
									</div>
								</div>
								<div class="col-md-6">
<?php
$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'avatar-form'
    ]
]);
?>
									<div class="form-group">
										<?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-block',"id"=>"saveAvatarButton"])?>
									</div>
									<?php ActiveForm::end(); ?>
								</div>
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


