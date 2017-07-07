<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */
/* @var $this \yii\web\View */

use yii\widgets\ActiveForm;

$this->title = '留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'content')->widget(\common\widgets\editor\editormd\Editormd::className()) ?>
<div class="form-group">
    <button class="btn btn-primary">提交</button>
</div>
<?php ActiveForm::end() ?>
