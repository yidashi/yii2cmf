<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\attachment\assets\AttachmentIndexAsset;
use common\modules\attachment\models\MediaItem;
use common\modules\attachment\models\Attachment;

/* @var $this yii\web\View */
/* @var $searchModel Attachment */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var Attachment $model */

$this->title = '附件';
$this->params['breadcrumbs'][] = $this->title;


/** @var AttachmentIndexAsset $bundle */
$bundle = AttachmentIndexAsset::register($this);


?>
<div class="row">
	<div class="col-md-8">
		<div class="box box-solid ">
			<div class="box-body">
				<div class="row items" id="attachment-list"
					data-url="<?= Url::to(['view']) ?>">
					<?php foreach ($dataProvider->getModels() as $model):?>
					<div class="col-md-2 item margin-bottom"
						data-item-id="<?php echo $model->primaryKey ?>">
						<?php
        $media = MediaItem::createFromAttachment($model);
        switch ($media->getFileType()) {
            case MediaItem::FILE_TYPE_IMAGE:
                echo Html::a(Html::img($model->url), $model->url);
                break;
            default:
                echo Html::a(Html::img($bundle->baseUrl."/images/".$media->getFileType().".png"), $model->url);
        }
        ?>
                    <span class="checked glyphicon glyphicon-check"></span>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<div class="box-footer ">
				<div class="box-tools pull-right">
					<?=yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination,'options'=>['class' => 'pagination pagination-sm inline']])?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
        	<?= Html::a('上传文件', ['uploader'], ['class' => 'btn bg-maroon btn-flat btn-block '])?>
        </div>
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">文件信息</h3>
			</div>
			<div class="box-body">
				<div id="attachment-info">
					<h6>选择文件查看详情.</h6>
				</div>
			</div>
		</div>
	</div>
</div>