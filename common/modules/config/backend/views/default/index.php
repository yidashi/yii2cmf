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
            <li<?php if ($k == $group): ?> class="active"<?php endif; ?>><?= Html::a($g, ['index', 'group' => $k]) ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php
        $form = ActiveForm::begin(['action' => ['store', 'group' => $group]]);
        foreach ($configModels as $index => $configModel) {
            echo $form->field($configModel, "[$index]value")->label($configModel->description)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(),[
                'data' => $configModel->extra,
                'type' => $configModel->type
            ]);
        }
        echo Html::submitButton('提交', ['class' => 'btn btn-primary btn-flat btn-block']);
        ActiveForm::end();
        ?>
    </div>
</div>