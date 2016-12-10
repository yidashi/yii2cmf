<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/** @var \hass\attachment\models\Attachment $model */
/** @var \yii\web\AssetBundle $bundle */
/** @var \hass\attachment\helpers\MediaItem $media */
?>
<div class=" attachment_video">

<?php echo Html::tag("video","Your browser does not support the video tag.",["src"=>$model->getUrl(), "controls"=>"controls","width"=>"320","height"=>"240"])?>

</div>