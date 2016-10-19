<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:45
 */
/**
 * @var $this \yii\web\View;
 */
$this->title = '发新私信';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?= $this->renderFile('@common/modules/user/views/_menu.php') ?>
        </div>
        <div class="col-md-9">
            <div class="row">
                <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="btn btn-success btn-sm pull-right"><?= \yii\helpers\Html::icon('arrow-left') ?> 返回列表</a>
            </div>
            <?php $form = \yii\widgets\ActiveForm::begin() ?>
            <?= $form->field($model, 'toUsername') ?>
            <?= $form->field($model, 'toUid')->label(false)->hiddenInput() ?>
            <?= $form->field($model, 'content')->textarea(['rows' => 5]) ?>
            <div class="form-group">
                <?= \yii\helpers\Html::submitButton('发送', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
    </div>
</div>

