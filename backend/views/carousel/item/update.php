<?php

/* @var $this yii\web\View */
/* @var $model common\models\CarouselItem */

$this->title = '更新幻灯片项： ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '幻灯片项', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->carousel->key, 'url' => ['/carousel/update', 'id' => $model->carousel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
