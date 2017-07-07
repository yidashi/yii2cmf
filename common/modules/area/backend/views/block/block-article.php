<?php

use backend\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'model-form'
    ]
]);
?>

<?= $form->field($model,"title") ?>

<?= $form->field($model,"slug") ?>

<?= $form->field($model,"cache")->checkbox() ?>

<?=$form->field($model, 'template[category]')->label('分类')->dropDownList(\common\models\Category::getDropDownList(), ['prompt' => '选择分类']) ?>

<?=$form->field($model, 'template[order]')->label('排序')->radioList(['published_at' => '发布时间', 'view' => '点击量', 'favourite' => '收藏最多', 'is_hot' => '热门', 'is_top' => '置顶']) ?>

<?=$form->field($model, 'template[limit]')->label('数量')->textInput(['value' => 10]) ?>


	<?=Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block' ])?>
<?php ActiveForm::end();?>