<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\config\models\Config */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'value',
            'description',
        ],
    ]) ?>
    </div>
</div>
