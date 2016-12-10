<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/** @var \hass\attachment\models\Attachment $model */
/** @var \yii\web\AssetBundle $bundle */
/** @var \hass\attachment\helpers\MediaItem $media */
?>
<div class=" attachment_document">
<?php  echo Html::img($bundle->baseUrl."/images/".$media->getFileType().".png");?>
<?php echo Html::a("查看", $model->getUrl(),['target'=>"_blank"]); ?>
</div>