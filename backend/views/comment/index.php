<?php

use common\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'user_id',
                        'value' => function($model) {
                            return $model->user->username;
                        }
                    ],
                    'type',
                    'type_id',
                    [
                        'attribute' => 'content',
                        'options' => ['width' => '40%'],
                        'value' => function($model) {
                            return \yii\helpers\Markdown::process($model->content);
                        },
                        'format' => 'html'
                    ],
                     'up',
                     'down',
                    'created_at:datetime',
                    [
                        'class' => 'backend\widgets\grid\ActionColumn',
                        'template' => '{view} {delete} {ban}',
                        'buttons' => [
                            'ban' => function($url, $model, $key) {
                                return Html::a(Html::icon('ban'),
                                    ['/user/ban'],
                                    ['title' => '封禁用户', 'data-method' => 'post', 'data-params' => ['id' => $model->user_id]]
                                );
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
