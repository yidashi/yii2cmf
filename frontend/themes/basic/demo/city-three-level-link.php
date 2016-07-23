<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午12:05
 */
$this->title = '城市三级联动';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?= $form->field($model, 'area')->label('所在地')->widget(\common\widgets\city\CityWidget::className(), [
    'provinceAttribute' => 'province',
    'cityAttribute' => 'city',
    'areaAttribute' => 'area'
]) ?>
<?= \yii\helpers\Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
<?php \yii\widgets\ActiveForm::end() ?>
