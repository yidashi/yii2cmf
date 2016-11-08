<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @var \yii\web\View $this */
$this->title = "清除缓存";
?>

<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<div class="col-md-6 text-center">
                <?= Html::a('<i class="glyphicon glyphicon-flash"></i> 清除缓存', ['/cache/flush-cache'], ['class' => 'btn btn-default', 'data-method' => 'post']) ?>
			</div>
			<div class="col-md-6">
				<h5 class="col-md-3">删除一个缓存</h5>
            <?php ActiveForm::begin([
                'action' => \yii\helpers\Url::to(['flush-cache-key']),
                'method' => 'post',
                'layout' => 'inline',
                'options' => ['class' => 'col-md-9']
            ])?>
 
                <?= Html::input('string', 'key', null, ['class'=>'form-control', 'placeholder' => 'key'])?>
                <?= Html::submitButton('删除', ['class'=>'btn btn-danger'])?>
            <?php ActiveForm::end()?>
        </div>
		</div>

	</div>
</div>

