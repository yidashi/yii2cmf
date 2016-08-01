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
    <ul class="nav nav-pills">
        <?php foreach($groups as $k => $g): ?>
            <li<?php if ($k == $group): ?> class="active"<?php endif; ?>><?= \common\helpers\Html::a($g, ['config', 'group' => $k]) ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="box box-primary">
        <div class="box-body">
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
</div>