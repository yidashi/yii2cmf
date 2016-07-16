<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Gather */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gathers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gather-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'category',
            'url:url',
            'url_org:url',
            'res',
            'result',
        ],
    ]) ?>

</div>
