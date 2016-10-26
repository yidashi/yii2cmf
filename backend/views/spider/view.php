<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spiders'), 'url' => ['index']];
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
</div>
