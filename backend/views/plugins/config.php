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
<div class="box box-primary">
    <div class="box-body">
        <?php
        $form = ActiveForm::begin();
        foreach ($configModels as $index => $configModel) {
            echo $form->field($configModel, "[$index]value")->label($configModel->desc)->widget(\common\widgets\dynamicInput\DynamicInputWidget::className(),[
                'data' => $configModel->extra,
                'type' => $configModel->type
            ]);
        }
        echo Html::submitButton('提交', ['class' => 'btn btn-primary btn-flat']);
        ActiveForm::end();
        ?>
    </div>
</div>