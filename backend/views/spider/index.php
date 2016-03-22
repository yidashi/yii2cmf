<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '蜘蛛';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spider-index">

    <p>
        <?= Html::a('添加蜘蛛', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'title',
            'domain',
            // 'page_dom',
            // 'list_dom',
            // 'time_dom',
            // 'content_dom',
            // 'title_dom',
            // 'target_category',
            // 'target_category_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
