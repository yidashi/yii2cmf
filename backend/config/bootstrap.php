<?php
Yii::$container->set('yii\data\Pagination', ['defaultPageSize' => 15]);
Yii::$container->set('yii\grid\ActionColumn', ['buttonOptions' => ['class' => 'btn btn-default btn-xs']]);
Yii::$container->set('yii\grid\GridView', [
    'tableOptions' => ['class' => 'table table-bordered table-hover table-responsive'],
    'layout' => "{items}\n<div class='clearfix'><div class='pull-right'>{summary}\n{pager}</div></div>",
    'summaryOptions' => ['class' => 'pagination-summary'],
]);
Yii::$container->set('yii\grid\DataColumn', [
    'sortLinkOptions' => ['class' => 'sorting'],
]);