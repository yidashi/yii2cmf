<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\bootstrap\Nav;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */

/* @var $this yii\web\View */
/* @var $searchModel hass\area\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>


<div class="row">
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">区块列表</h3>
				<div class="box-tools">
					<button class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body no-padding" style="display: block;">
			</div>
			<!-- /.box-body -->
		</div>

	</div>
	<div class="col-md-9">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">文本块</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
                <?= $this->render('block-text',["model"=>$model]) ?>
			</div>
		</div>
	</div>
	</div>