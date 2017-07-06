<?php
/**
 * @var \yii\web\View $this
 */
use yii\helpers\Html;
use backend\widgets\ActiveForm;

$this->title = '设置';
?>
<div class="container profile">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('../_menu')?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'username')->textInput(['disabled' => 'disabled']) ?>
                    <?php
                    $emailOptions = [];
                    if ($model->isConfirmed) {
                        $emailOptions = ['disabled' => 'disabled'];
                    }
                    ?>
                    <?= $form->field($model, 'email')->suffix($model->isConfirmed ? '已验证' : '<button class="btn btn-primary" type="button" id="confirm-email">验证</button>', $model->isConfirmed ? 'addon' : 'btn')->textInput($emailOptions) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- profile -->
<?php $this->beginBlock('js') ?>
<script>
    $('#confirm-email').on('click', function () {
        var email = $('#<?= Html::getInputId($model, 'email') ?>').val();
        $.post('<?= \yii\helpers\Url::to(['send-confirm']) ?>', {email:email}, function (res) {
            if (res.status) {
                $.modal.success(res.msg);
                $('#confirm-email').text('已发送').addClass('disabled').off('click');
            } else {
                $.modal.error(res.msg);
            }
        }, 'json')
    });
</script>
<?php $this->endBlock() ?>
