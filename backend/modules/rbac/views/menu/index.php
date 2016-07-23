<?php

use common\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
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
                        'label' => Yii::t('rbac-admin', 'Parent'),
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
                        'class' => 'yii2tech\admin\grid\PositionColumn',
                        'attribute' => 'order'
                    ],
                    [
                        'class' => 'backend\widgets\grid\ActionColumn',
                        'template' => '{create} {view} {update} {delete}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
