<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'route',
                    'user_id',
                    [
                        'attribute' => 'ip',
                        'value' => function($model) {
                            return long2ip($model->ip);
                        }
                    ],
                    'created_at:datetime',

                    [
                        'class' => 'backend\widgets\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
