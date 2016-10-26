<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '页面管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'use_layout',
            'content:ntext',
            'title',
            'slug'
        ],
    ]) ?>

</div>
