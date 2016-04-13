<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/13
 * Time: 下午2:59
 */
use common\helpers\Html;
?>
<span><a href="" data-toggle="modal" data-target="#rewardModal"><?= Html::icon('cny')?> 打赏作者</a></span>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'rewardModal',
    'header' => '<h2>您的支持将鼓励作者继续创作</h2>'
])?>
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['/reward/index']])?>
    <?= $form->field($rewardModel, 'article_id')->hiddenInput()->label(false) ?>
    <?= $form->field($rewardModel, 'money')?>
    <?= $form->field($rewardModel, 'comment')?>
    <p>使用支付宝支付</p>
    <div class="clearfix">
        <div class="pull-right">
            <?= Html::button('取消打赏', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' ' . Html::submitButton('确认支付', ['class' => 'btn btn-primary'])?>
        </div>
    </div>
    <?php \yii\widgets\ActiveForm::end()?>
<?php \yii\bootstrap\Modal::end()?>
