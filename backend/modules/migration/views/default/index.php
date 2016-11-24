<?php
use backend\widgets\ActiveForm;
use yii\helpers\Html;
use migration\assets\MigrationAsset;
use migration\models\MigrationUtility;

/** @var $model MigrationUtility */
/** @var $output String */
/** @var $output_drop String */
/** @var $tables array */
/** @var ActiveForm $form */
MigrationAsset::register($this);
$this->title = Yii::t('backend', '迁移');
?>
<?php $form = ActiveForm::begin(['id' => 'form-submit']); ?>
<div class="box box-primary">
	<div class="box-body">
	  <?= $form->field($model, 'migrationName')->textInput()?>
	  <?= $form->field($model, 'migrationPath')->textInput()?>
	  <?= $form->field($model, 'tableOption')->textInput()?>
	</div>
</div>

<?= $form->boxField($model, "tableSchemas")->checkboxList(MigrationUtility::getTableNames())->header("迁移表结构")->hint(Html::a("全选",'javascript:void(0)',['class'=>"select-all"]))?>
<?= $form->boxField($model, "tableDatas")->checkboxList(MigrationUtility::getTableNames())->header("迁移表数据")->hint(Html::a("全选",'javascript:void(0)',['class'=>"select-all"]))?>

<div class="form-group">
     <?= Html::submitButton('生成迁移文件', ['class' => 'btn bg-maroon btn-flat btn-block ', 'name' => 'button-submit', 'id' => 'button-submit'])?>
</div>
<?php ActiveForm::end()?>


