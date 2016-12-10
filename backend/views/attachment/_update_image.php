<?php 
use yii\helpers\Html;
use hass\attachment\enums\CropType;

use yii\helpers\Url;
use yii\web\View;
/** @var \hass\attachment\models\Attachment $model */
/* @var $this yii\web\View */
$this->registerJs("var cropUrl = '".Url::to(["crop","id"=>Yii::$app->getRequest()->get("id")])."'",View::POS_HEAD);
?>
<div class="row attachment_image">
			<div class="col-md-9" id="interface">
				<?php echo  Html::img($model->getUrl(),["class"=>"original-image"])?>

			</div>
			<div class="col-md-3">
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">当前缩略图</h3>
					</div>
					<div class="box-body">
						<?php echo Html::img($model->getThumb(264,148))?>
					</div>
				</div>

				<div class="box box-solid">
					<div class="box-body">
						<form onsubmit="return false;" id="text-inputs">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="cx" class="col-sm-2 control-label">X</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cx" id="crop-x"
											placeholder="X">
									</div>

								</div>
								<div class="col-md-6 form-group">

									<label for="cy" class="col-sm-2 control-label">Y</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cy" id="crop-y"
											placeholder="Y">
									</div>
								</div>
								<div class="col-md-6 form-group">
									<label for="cw" class="col-sm-2 control-label">W</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cw" id="crop-w"
											placeholder="W">
									</div>
								</div>
								<div class="col-md-6 form-group">
									<label for="ch" class="col-sm-2 control-label">H</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="ch" id="crop-h"
											placeholder="H">

									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">裁剪设置</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<strong>将裁剪应用于：</strong>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::ALL?>"> 所有图像大小
								</label>
							</div>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::THUMBNAIL?>" checked=""> 只应用于缩略图
								</label>
							</div>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::ORIGINAL?>"> 只应用于原图
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<?= Html::button("裁剪", ['class' => 'btn bg-maroon margin btn-flat', "id"=>"setSelectButton"])?>
						<?= Html::button("保存", ['class' => 'btn bg-maroon margin btn-flat hide', "id"=>"cropButton"])?>
						<?= Html::button("取消", ['class' => 'btn bg-maroon margin btn-flat hide', "id"=>"releaseButton"])?>
					</div>
				</div>
			</div>
		</div>