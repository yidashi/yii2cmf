<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var yii\web\View $this
 * @var rbac\models\Route $model
 * @var ActiveForm $form
 */

$this->title = Yii::t('rbac', 'Create Route');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Routes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="create">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'route') ?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('rbac', 'Create'), ['class' => 'btn btn-primary btn-flat']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- create -->
