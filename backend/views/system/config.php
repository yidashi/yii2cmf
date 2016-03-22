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
    <?php
    $form = ActiveForm::begin();

    foreach ($configs as $index => $config) {
        echo call_user_func_array([$form->field($config, "[$index]value")->label($config->desc), $config->inputType['name']], $config->inputType['params']);
    }
    echo Html::submitButton('提交', ['class' => 'btn btn-primary']);
    ActiveForm::end();
    ?>
</div>