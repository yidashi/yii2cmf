<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use common\modules\attachment\assets\AttachmentUpdateAsset;
use common\modules\attachment\models\MediaItem;


/* @var $this yii\web\View */
/* @var $searchModel common\modules\attachment\models\Attachment */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\modules\attachment\models\Attachment */

$this->title = '编辑附件';
$this->params['breadcrumbs'][] = [
    "label" => "附件首页",
    "url" => [
        "index"
    ]
];
$this->params['breadcrumbs'][] = $this->title;
/** @var AttachmentUpdateAsset $bundle */
$bundle = AttachmentUpdateAsset::register($this);
?>
<div class="row">
	<div class="col-md-9">
		<?php
        $media = MediaItem::createFromAttachment($model);
        echo $this->render("_update_" . $media->getFileType(), ['model'=>$model, "media"=>$media, "bundle" => $bundle]);
        ?>
	</div>
	<div class="col-md-3">
		<?php
		$form = ActiveForm::begin([
		    'options' => [
		        'enctype' => 'multipart/form-data',
		        'class' => 'model-form'
		    ]
		]);
		?>
		<div class="box box-solid">
			<div class="box-body">
				<?php echo $this->render("_info",["model"=>$model]);?>
				<?= $form->field($model, 'title')->textInput(['class' => 'form-control']); ?>
				<?= $form->field($model, 'description')->textarea(['class' => 'form-control']); ?>
			</div>
			<div class="box-footer">
				<?= Html::submitButton("更新附件", ['class' => 'btn bg-maroon margin btn-flat'])?>
				<?=Html::a("删除附件", ['delete','id' => $model->primaryKey], ['class' => 'btn btn-default margin  btn-flat','data-item-id'=>$model->primaryKey,'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),'role' => 'delete'])?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>

