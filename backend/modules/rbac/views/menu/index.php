<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel rbac\models\searchs\Menu */

$this->title = Yii::t('rbac', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('新菜单', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    [
                        'attribute' => 'menuParent.name',
                        'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                            'class' => 'form-control', 'id' => null,
                        ]),
                        'label' => Yii::t('rbac', 'Parent'),
                    ],
                    'route',
                    [
                        'attribute' => 'icon',
                        'value' => function($model) {
                            return Html::icon($model->icon);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'backend\widgets\grid\PositionColumn',
                        'attribute' => 'order'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{create} {view} {update} {delete}',
                        'buttons' => [
                            'create' => function($url, $model) {
                                return Html::a(Html::icon('plus'), ['create', 'id' => $model->id]);
                            }
                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
