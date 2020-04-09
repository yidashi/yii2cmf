<?php

use backend\widgets\ActiveForm;
use backend\widgets\meta\MetaForm;
use common\modules\document\models\Category;
use common\modules\document\models\DocumentModule;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Category */
/* @var $form backend\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">基本</a></li>
            <li><a href="#tab_2" data-toggle="tab" aria-expanded="true">选项</a></li>
            <li><a href="#tab_3" data-toggle="tab" aria-expanded="true">模板</a></li>
        </ul>
    </div>
    <div class="box-body">

    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?= $form->field($model, 'pid')->dropDownList(Category::getDropDownList(Category::lists()), ['prompt' => '请选择']) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'module')->suffix(Html::a('管理内容模型', ['/document/document-module/index'], ['class' => 'btn btn-default', 'target' => '_blank']), 'btn')->dropDownList(DocumentModule::getTypeEnum(), ['prompt' => '请选择']) ?>
        </div>

        <div class="tab-pane" id="tab_2">

            <?= $form->field($model, 'sort')->textInput() ?>

            <?= $form->field($model, 'allow_publish')->inline()->radioList($model::getAllowPublishEnum()) ?>

            <?= $form->boxField($model, 'meta', ["collapsed" => true])->widget(MetaForm::className())->header("SEO"); ?>
        </div>

        <div class="tab-pane" id="tab_3">
            <?= $form->field($model, 'list_template')->textInput() ?>

            <?= $form->field($model, 'content_template')->textInput() ?>

        </div>
    </div>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => 'btn btn-primary btn-flat']) ?>
</div>

</div>
<?php ActiveForm::end(); ?>

<?php $this->beginBlock('js') ?>
<script>
    var $slugInput = $("#<?= Html::getInputId($model, 'slug') ?>");
    var $titleInput = $("#<?= Html::getInputId($model, 'title') ?>");
    var url = "<?= \yii\helpers\Url::to(['generate-slug']) ?>";
    $slugInput.on('focus', function () {
        $.get(url, {title:$titleInput.val()}, function (res) {
            $slugInput.val(res);
        })
    })
</script>
<?php $this->endBlock() ?>
