<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/** @var common\models\Attachment $model */
/** @var \yii\web\AssetBundle $bundle */
/** @var \backend\models\MediaItem $media */
?>
<div class=" attachment_video">

<?= Html::tag("video","Your browser does not support the video tag.",["src"=>$model->url, "controls"=>"controls","width"=>"320","height"=>"240"])?>

</div>