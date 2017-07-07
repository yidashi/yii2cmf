<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $activeGenerator \yii\gii\Generator */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$activeGenerator = Yii::$app->controller->generator;

$asset = gii\GiiAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<div class="row">
	<div class="col-md-3 col-sm-4">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">生成类型</h3>
			</div>
			<div class="box-body no-padding">
				<ul class="nav nav-pills nav-stacked">
			                  <?php
                    foreach ($generators as $id => $generator) {
                        
                        echo Html::tag("li", Html::a(Html::encode($generator->getName()), [
                            'default/view',
                            'id' => $id
                        ]), [
                            'class' => $generator === $activeGenerator ? 'active' : ''
                        ]);
                    }
                    ?>
			
			</ul>

			</div>
		</div>
	</div>
	<div class="col-md-9 col-sm-8">
        <?= $content?>
    </div>
</div>
<?php $this->endContent(); ?>
