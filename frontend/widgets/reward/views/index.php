<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午4:57
 */
use yii\helpers\Html;

?>

<span><a href="" data-toggle="modal" data-target="#rewardModal"><?= Html::icon('cny')?> 打赏作者</a></span>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'rewardModal',
    'header' => '<h2>您的支持将鼓励作者继续创作</h2>'
])?>
<?php $form = \yii\widgets\ActiveForm::begin(['action' => ['/reward/index']])?>
<?= $form->field($model, 'article_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'money')?>
<?= $form->field($model, 'comment')?>
<div class="clearfix">
    <div class="pull-right">
        <?= Html::button('取消打赏', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])?>
        <?php if(Yii::$app->user->isGuest) : ?>
        <?= Html::a('登录', ['/site/login'], ['class' => 'btn btn-primary']) ?>
        <?php  else: ?>
        <?= Html::submitButton('确认打赏', ['class' => 'btn btn-primary'])?>
        <?php endif; ?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end()?>
<?php \yii\bootstrap\Modal::end()?>
