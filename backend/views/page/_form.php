<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?php if ($model->isNewRecord): ?>
            <?= Html::dropDownList('choose-editor', request('editor') ? : config('editor.type_page'), config('editor.type_list'), ['id' => 'choose-editor']) ?>
        <?php endif; ?>
        <?= $form->field($model, 'content')->widget(\common\widgets\EditorWidget::className(), $model->isNewRecord ? ['type' => request('editor') ? : config('editor.type_page')] : ['isMarkdown' => $model->markdown]) ?>

    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'use_layout')->checkbox() ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => 'btn btn-flat bg-maroon btn-block']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->beginBlock('js') ?>
<script>
    $(document).on('change', '#choose-editor', function(){
        var url = '<?= \yii\helpers\Url::to(['create']) ?>';
        var type = $(this).val();
        url = url.addQueryParams({editor:type});
        location.href = url;
    })
</script>
<?php $this->endBlock() ?>
