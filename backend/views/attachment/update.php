<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
use yii\helpers\Html;
use hass\base\misc\adminlte\ActiveForm;
use hass\attachment\assets\AttachmentUpdateAsset;
use hass\attachment\helpers\MediaItem;


/* @var $this yii\web\View */
/* @var $searchModel \hass\attachment\models\AttachmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model yii\db\ActiveRecord */

$this->title = Yii::t('hass/attachment', '编辑附件');
$this->params['breadcrumbs'][] = [
    "label" => "附件首页",
    "url" => [
        "index"
    ]
];
$this->params['breadcrumbs'][] = $this->title;
/** @var \hass\attachment\assets\AttachmentUpdateAsset $bundle */
$bundle = AttachmentUpdateAsset::register($this);
?>
<div class="row">
	<div class="col-md-9">
		<?php
        $media = MediaItem::createFromAttachment($model);
        echo $this->render("_update_".$media->getFileType(),['model'=>$model,"media"=>$media,"bundle"=>$bundle]);
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
				<?=Html::a("删除附件", ['delete','id' => $model->primaryKey], ['class' => 'btn bg-default margin  btn-flat','data-item-id'=>$model->primaryKey,'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),'role' => 'delete'])?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>

