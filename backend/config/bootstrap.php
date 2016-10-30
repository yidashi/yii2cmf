<?php
Yii::$container->set('yii\data\Pagination', ['defaultPageSize' => 10]);
Yii::$container->set('yii\grid\ActionColumn', ['buttonOptions' => ['class' => 'btn btn-default btn-xs']]);
Yii::$container->set('yii\grid\GridView', ['tableOptions' => ['class' => 'table table-bordered']]);