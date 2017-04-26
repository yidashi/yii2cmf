<?php
/* @var $this yii\web\View */
/* @var $model common\models\WidgetNav */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Nav',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-Nav-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
