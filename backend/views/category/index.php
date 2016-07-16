<?php

use common\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id:text:ID',
                    'title:html:分类名',
                    'name:text:标识',
                    'article:text:文章数',
                    'is_nav:boolean:是否显示导航栏',
                    'sort',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{add} {update} {delete}',
                        'buttons' => [
                            'add' => function($url, $model, $key) {
                                return Html::a(Html::icon('plus'), ['create', 'pid' => $model['id']]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
