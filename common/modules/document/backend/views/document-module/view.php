<?php

use common\modules\document\models\DocumentModule;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model DocumentModule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '内容模型', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'title',
        ],
    ]) ?>
    </div>
</div>
