<?php

use common\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-header"><h2 class="box-title">文章搜索</h2></div>
        <div class="box-body"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
    </div>
    <div class="box box-primary">
        <div class="box-header"><h2 class="box-title">文章列表</h2></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'title',
                        'value' => function($model) {
                            return Html::a($model->title, env('FRONTEND_URL') . '/' . $model->id . '.html', ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    'category',
                    [
                        'attribute' => 'is_top',
                        'value' => function($model) {
                            $source = [
                                [
                                    'value' => 0,
                                    'text' => '否'
                                ],
                                [
                                    'value' => 1,
                                    'text' => '是'
                                ]
                            ];
                            return \dosamigos\editable\Editable::widget([
                                'name' => 'is_top',
                                'type' => 'select',
                                'url' => '/article/ajax-update-field',
                                'clientOptions' => [
                                    'pk' => $model->id,
                                    'source' => $source,
                                    'value' => $model->is_top,
                                    'showbuttons' => false,
                                    'escape' => false
                                ]
                            ]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            $source = [
                                [
                                    'value' => 0,
                                    'text' => '待审'
                                ],
                                [
                                    'value' => 1,
                                    'text' => '通过'
                                ]
                            ];
                            return \dosamigos\editable\Editable::widget([
                                'name' => 'status',
                                'type' => 'select',
                                'url' => '/article/ajax-update-field',
                                'clientOptions' => [
                                    'pk' => $model->id,
                                    'source' => $source,
                                    'value' => $model->status,
                                    'showbuttons' => false,
                                    'escape' => false
                                ]
                            ]);
                        },
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
