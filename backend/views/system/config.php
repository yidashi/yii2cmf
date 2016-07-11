<?php
/**
 * author: yidashi
 * Date: 2016/1/11
 * Time: 18:01.
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '网站设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body">
    <?php
    $form = ActiveForm::begin();
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns' => [
            'desc',
            [
                'attribute' => 'value',
                'value' => function($model, $key, $index) use ($form) {
                    return call_user_func_array([$form->field($model, "[$index]value")->label(false), $model->inputType['name']], $model->inputType['params']);
                },
                'format' => 'raw'
            ],
            'name'
        ]
    ]);

    echo Html::submitButton('提交', ['class' => 'btn btn-primary']);
    ActiveForm::end();
    ?>
            </div></div>
</div>