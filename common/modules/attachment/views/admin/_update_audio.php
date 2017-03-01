<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/** @var \hass\attachment\models\Attachment $model */
/** @var \yii\web\AssetBundle $bundle */
/** @var \hass\attachment\helpers\MediaItem $media */
?>
<div class=" attachment_audio">
<?php echo Html::tag("audio","Your browser does not support the audio tag.",["src"=>$model->url, "controls"=>"controls"])?>
</div>