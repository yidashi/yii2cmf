<?php 
use yii\helpers\Html;

use yii\helpers\Url;
use yii\web\View;
/** @var common\modules\attachment\models\Attachment $model */
/* @var $this yii\web\View */
$this->registerJs("var cropUrl = '".Url::to(["crop", "id"=>Yii::$app->getRequest()->get("id")]) . "'", View::POS_HEAD);
?>
<div class="row attachment_image">
			<div class="col-md-9" id="interface">
				<?= Html::img($model->url, ["class"=>"original-image"])?>

			</div>
			<div class="col-md-3">
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">当前缩略图</h3>
					</div>
					<div class="box-body">
						<?= Html::img($model->getUrl())?>
					</div>
				</div>

				<div class="box box-solid">
					<div class="box-body">
						<form onsubmit="return false;" id="text-inputs">
							<div class="row">
								<div class="col-md-12 form-group">
									<label for="cx" class="col-sm-2 control-label">X</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cx" id="crop-x"
											placeholder="X">
									</div>

								</div>
								<div class="col-md-12 form-group">

									<label for="cy" class="col-sm-2 control-label">Y</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cy" id="crop-y"
											placeholder="Y">
									</div>
								</div>
								<div class="col-md-12 form-group">
									<label for="cw" class="col-sm-2 control-label">W</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cw" id="crop-w"
											placeholder="W">
									</div>
								</div>
								<div class="col-md-12 form-group">
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
					<div class="box-footer">
						<?= Html::button("裁剪", ['class' => 'btn bg-maroon margin btn-flat', "id" => "setSelectButton"])?>
						<?= Html::button("保存", ['class' => 'btn bg-maroon margin btn-flat hide', "id" => "cropButton"])?>
						<?= Html::button("取消", ['class' => 'btn bg-maroon margin btn-flat hide', "id" => "releaseButton"])?>
					</div>
				</div>
			</div>
		</div>