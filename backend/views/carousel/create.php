<?php
/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = '新建幻灯片';
$this->params['breadcrumbs'][] = ['label' => '幻灯片', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
