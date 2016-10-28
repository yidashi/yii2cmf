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
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php foreach($groups as $k => $g): ?>
            <li<?php if ($k == $group): ?> class="active"<?php endif; ?>><?= \yii\helpers\Html::a($g, ['config', 'group' => $k]) ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php
        $form = ActiveForm::begin(['action' => ['store-config', 'group' => $group]]);
        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'columns' => [
                'description',
                [
                    'attribute' => 'value',
                    'value' => function($model, $key, $index) use ($form) {
                        return $form->field($model, "[$index]value")->label(false)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(),[
                            'data' => $model->extra,
                            'type' => $model->type
                        ]);
                    },
                    'format' => 'raw'
                ],
                'name'
            ]
        ]);

        echo Html::submitButton('提交', ['class' => 'btn btn-primary btn-flat btn-block']);
        ActiveForm::end();
        ?>
    </div>
</div>