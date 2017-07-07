<?php

use common\modules\area\assets\AreaAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $this \yii\web\View
 */
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = '区域';
$this->params['breadcrumbs'][] = $this->title;
AreaAsset::register($this);

$this->registerJs("var updateBlocksUrl = '".Url::to(["update-blocks"])."'",View::POS_HEAD);
?>

<?php $this->beginBlock('content-header'); ?>
<h1>
	<?= $this->title?> <a class="btn btn-primary btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>">新区域</a>
</h1>
<?php $this->endBlock(); ?>


<div class="row">
	<div class="col-md-6">

	<ul class="sortable grid clearfix" data-domain="0">
<?php foreach ($blocks as $block):?>
    <li data-block="<?= $block->primaryKey; ?>" class="clearfix">
        <span class="pull-left"><?= $block->title?></span>
        <span class="pull-right"><a href="<?= Url::to(["/block/update", "id" => $block->primaryKey])?>"><i class="fa fa-pencil"></i></a></span>
    </li>
<?php endforeach;?>
</ul>




</div>
	<div class="col-md-6">
<div class="row">

<?php foreach($areas as $area) : ?>

<div class="col-md-6">
<div class="box box-widget">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $area->title?></h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool">
						<a href="<?= Url::to(["update","id"=>$area->primaryKey]);?>"><i class="fa fa-pencil"></i></a>
					</button>
					<button class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body">
                <ul class="sortable" data-domain="<?php echo $area->primaryKey?>">

                <?php foreach ($area->getBlocks() as $block):?>
                    <li data-block="<?= $block->primaryKey; ?>" class="clearfix">
                        <span class="pull-left"><?= $block->title?></span>
                        <span class="pull-right"><a href="<?= Url::to(["/block/update", "id" => $block->primaryKey])?>"><i class="fa fa-pencil"></i></a></span>
                    </li>
                <?php endforeach;?>

                </ul>


                </div>
			<!-- /.box-body -->
		</div>


</div>
	<?php endforeach;?>
</div>
	</div>

</div>



