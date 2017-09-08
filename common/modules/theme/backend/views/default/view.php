<?php

\common\modules\theme\backend\assets\ThemeAsset::register($this);
/* @var $model \frontend\themes\Theme */
$this->title = '主题详情';
$this->params['breadcrumbs'][] = [
    "label" => "主题",
    "url" => [
        "index"
    ]
];
?>


<div class="theme-overlay row">
	<div class="theme-screenshots col-md-7">



        <?php $screenshot = $model->getScreenshot();if(!empty($screenshot)):?>
		<div class="screenshot">
			<img src="<?= $screenshot?>" alt="">
		</div>
            <?php else :?>
		<div class="screenshot blank">没有截图</div>
            <?php endif;?>


	</div>

	<div class="theme-info col-md-5">

		<div class="box box-solid">

			<div class="box-header with-border">
				<h3 class=" box-title"><?= $model->getName() ?></h3>
				<span class="theme-version">版本：<?= $model->getVersion() ?></span>  <?php if( $model->isActive() == true):?>
		<span class="current-label">当前主题</span>
             <?php endif;?>
		</div>
			<div class="box-body">
				<h4 class="theme-author">
					由<?php echo $model->getAuthor() ?>创建
				</h4>
				<p class="theme-description"><?= $model->getDescription() ?></p>
				<p class="theme-tags ">
					<span>关键词：</span>
            <?= $model->getKeyWords() ?>
		</p>

			</div>

		</div>
	</div>
</div>