<?php
/** @var $this yii\web\View
 * @var $model common\models\NavItem
 * @var $nav common\models\Nav
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Nav Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Nav Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $nav->key, 'url' => ['update', 'id' => $nav->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="widget-Nav-item-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
