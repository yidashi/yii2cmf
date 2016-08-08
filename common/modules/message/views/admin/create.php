<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:45
 */
/**
 * @var $this \yii\web\View;
 */
$this->title = '群发站内信';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 5]) ?>
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('发送', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>