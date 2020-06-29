<?php
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Nav */
$this->title = '修改导航: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '导航', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改导航';
?>
<div class="row">
    <div class="col-md-4">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    <div class="col-md-8">
        <p>
            <?= Html::a('新导航项', ['/nav-item/create', 'nav_id'=>$model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        </p>
        <div class="box box-primary">
            <div class="box-body">
                <?= \backend\widgets\grid\TreeGrid::widget([
                    'dataProvider' => $navItemsProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'parent_id',
                    'parentRootValue' => 0, //first parentId value
                    'pluginOptions' => [
//                        'initialState' => 'collapse',
                    ],
                    'columns' => [
                        'title',
                        'url',
                        [
                            'class' => 'backend\widgets\grid\PositionColumn',
                            'attribute' => 'order',
                            'route' => '/nav-item/position'
                        ],
                        [
                            'class' => 'backend\widgets\grid\SwitcherColumn',
                            'attribute' => 'status',
                            'route' => ['/nav-item/switcher']
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'controller' => '/nav-item',
                            'template' => ' {create} {update} {delete}',
                            'buttons' => [
                                'create' => function ($url, $itemModel, $key) use ($model){
                                    return Html::a(Html::icon('plus'), ['/nav-item/create', 'parent_id' => $key, 'nav_id' => $model->id], ['class' => 'btn btn-default btn-xs btn-flat']);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
