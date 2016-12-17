<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午6:46
 */

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = '书';
$this->params['breadcrumbs'][] = '书';
?>
<p>
    <?= \yii\helpers\Html::a('新建书', 'create', ['class' => 'btn btn-primary btn-sm']) ?>
</p>
<div class="box box-solid">
    <div class="box-body">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'book_name',
                    'value' => function ($model) {
                        return \yii\helpers\Html::a($model->book_name, ['create-chapter', 'id' => $model->id]);
                    },
                    'format' => 'html'
                ],
                'created_at:date',
                [
                    'class' => 'yii\grid\ActionColumn'
                ]
            ]
        ]) ?>
    </div>
</div>
