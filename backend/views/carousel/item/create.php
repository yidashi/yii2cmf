<?php
/** @var $this yii\web\View
 * @var $model common\models\CarouselItem
 * @var $carousel common\models\Carousel
 */

$this->title = '新幻灯片项';
$this->params['breadcrumbs'][] = ['label' => '幻灯片', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $carousel->key, 'url' => ['/carousel/update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
