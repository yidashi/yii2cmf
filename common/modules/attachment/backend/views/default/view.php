<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\modules\attachment\models\Attachment */
/* @var $form yii\widgets\ActiveForm */

?>


<?php echo $this->render("_info",["model"=>$model]);?>


<?php
$form = ActiveForm::begin([
    'action' => [
        'view',
        'id' => $model->primaryKey
    ],
    'options' => [
        'id' => 'control-form'
    ]
]);
?>


<?= $form->field($model, 'title')->textInput(['class' => 'form-control']); ?>
<?= $form->field($model, 'description')->textarea(['class' => 'form-control']); ?>

<?= Html::submitButton("更新附件", ['class' => 'btn bg-maroon margin btn-flat'])?>
<?= Html::a("编辑附件", ['update','id' => $model->primaryKey],['class' => 'btn bg-navy margin btn-flat'])?>


<?php ActiveForm::end(); ?>

<?= Html::a("删除附件", ['delete','id' => $model->primaryKey], ['class' => 'btn btn-default margin btn-flat','data-item-id'=>$model->primaryKey,'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')])?>





