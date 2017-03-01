<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/** @var common\models\Attachment $model */
/** @var \yii\web\AssetBundle $bundle */
/** @var backend\models\MediaItem $media */
?>
<div class=" attachment_document">
<?= Html::img($bundle->baseUrl."/images/".$media->getFileType().".png"); ?>
<?= Html::a("查看", $model->url,['target'=>"_blank"]); ?>
</div>