<?php
/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Carousel',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Carousels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
