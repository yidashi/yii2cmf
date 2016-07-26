<?php
/** @var $this yii\web\View
 * @var $model common\models\CarouselItem
 * @var $carousel common\models\Carousel
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Carousel Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Carousel Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $carousel->key, 'url' => ['update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="widget-carousel-item-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
