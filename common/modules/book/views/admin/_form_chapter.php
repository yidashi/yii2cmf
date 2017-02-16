<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/16
 * Time: 下午5:50
 */

use backend\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Markdown;

?>

<?php $form = Activeform::begin() ?>
<?= $form->field($model, 'chapter_name') ?>

<?= $form->field($model, 'chapter_body')->widget(\common\widgets\editormd\Editormd::className(), ['clientOptions' => ['watch' => true, 'height' => 1000]]) ?>
<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end() ?>
