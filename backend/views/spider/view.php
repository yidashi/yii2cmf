<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Spiders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spider-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
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
            'title',
            'domain',
            'page_dom',
            'list_dom',
            'time_dom',
            'content_dom',
            'title_dom',
            'target_category',
            'target_category_url:url',
        ],
    ]) ?>

</div>
