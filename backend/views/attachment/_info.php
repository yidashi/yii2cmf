<?php
use hass\attachment\helpers\MediaItem;
$media = MediaItem::createFromAttachment($model);
?>
<?php if (is_file($media->path)):?>
<div id="misc-publishing-actions">
	<div class="misc-pub-section curtime misc-pub-curtime">
		<span id="timestamp">上传于：<?= $model->getCreatedDateTime()?></span>
	</div>
	<!-- .misc-pub-section -->

	<div class="misc-pub-section misc-pub-attachment">
		<label for="attachment_url">文件URL：</label> <input type="text"
			class="form-control" readonly="readonly" name="attachment_url"
			value="<?php echo $model->getUrl();?>">
	</div>

	<div class="misc-pub-section misc-pub-filetype">
		文件类型： <strong><?= $model->type ?></strong>
	</div>

	<div class="misc-pub-section misc-pub-filesize">
		文件大小： <strong><?= $media->sizeToString() ?></strong>
	</div>

		<div class="misc-pub-section misc-pub-filename">
		文件名： <strong><?php echo $model->name.".".$model->extension;?></strong>
	</div>
			  <?php if ($media->isImage()) : ?>
				<div class="misc-pub-section misc-pub-dimensions">
		分辨率： <strong><span ><?= $media->getResolution() ?></span>
		</strong>
	</div>
       <?php endif; ?>
</div>
<?php endif;?>