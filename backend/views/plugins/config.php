<?php
/**
 * author: yidashi
 * Date: 2016/1/11
 * Time: 18:01.
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '插件设置:' .' '.$model->name;
$this->params['breadcrumbs'][] = ['label' => '插件', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <?php
    $form = ActiveForm::begin();
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns' => [
            'desc:text:配置描述',
            [
                'attribute' => 'value',
                'label' => '配置值',
                'value' => function($model, $key, $index) use ($form) {
                    return $form->field($model, "[$index]value")->label(false)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(),[
                        'data' => $model->extra,
                        'type' => $model->type
                    ]);
                },
                'format' => 'raw'
            ],
            'name:text:配置名'
        ]
    ]);

    echo Html::submitButton('提交', ['class' => 'btn btn-primary btn-flat']);
    ActiveForm::end();
    ?>
</div>