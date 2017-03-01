<?php
use backend\models\MediaItem;

/**
 * @var \common\models\Attachment $model
 */
$media = MediaItem::createFromAttachment($model);
?>
<?php if (is_file($media->path)):?>
<div id="misc-publishing-actions">
	<div class="misc-pub-section curtime misc-pub-curtime">
		<span id="timestamp">上传于：<?= Yii::$app->formatter->asDatetime($model->created_at) ?></span>
	</div>
	<!-- .misc-pub-section -->

	<div class="misc-pub-section misc-pub-attachment">
		<label for="attachment_url">文件URL：</label>
        <input type="text" class="form-control" readonly="readonly" id="attachment_url" value="<?= $model->url;?>" />
	</div>

	<div class="misc-pub-section misc-pub-filetype">
		文件类型： <strong><?= $model->type ?></strong>
	</div>

	<div class="misc-pub-section misc-pub-filesize">
		文件大小： <strong><?= $media->sizeToString() ?></strong>
	</div>

    <div class="misc-pub-section misc-pub-filename">
		文件名： <strong><?= $model->name ?></strong>
	</div>
    <?php if ($media->isImage()) : ?>
    <div class="misc-pub-section misc-pub-dimensions">
		宽高： <strong><span ><?= $media->getResolution() ?></span></strong>
	</div>
   <?php endif; ?>
</div>
<?php endif;?>