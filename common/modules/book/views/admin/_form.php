<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/16
 * Time: 下午5:42
 */

use yii\helpers\Html;
use yii\helpers\Markdown;
use backend\widgets\ActiveForm;

?>

<div class="box box-solid">
    <div class="box-body">
        <?php $form = Activeform::begin() ?>
        <?= $form->field($model, 'book_name') ?>

        <?= $form->field($model, 'book_cover')->widget(\common\modules\attachment\widgets\SingleWidget::className()) ?>

        <?= $form->field($model, 'book_description')->widget(\common\widgets\editormd\Editormd::className(), ['clientOptions' => ['watch' => true, 'height' => 1000]]) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
