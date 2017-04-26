<?php


/* @var $this yii\web\View */
/* @var $model rbac\models\AuthItem */

$this->title = Yii::t('rbac', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">


	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
