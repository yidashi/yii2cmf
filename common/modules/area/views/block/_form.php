
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= array_get(\common\modules\area\models\Block::widgetTypeEnum(), $model->type) ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
                <?= $this->render('block-' . $model->type,["model"=>$model]) ?>
			</div>
		</div>
