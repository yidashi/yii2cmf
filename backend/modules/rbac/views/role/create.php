<?php


/*
 * @var yii\web\View $this
 * @var rbac\models\AuthItem $model
 */

$this->title = Yii::t('rbac', 'Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">


	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
