<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model common\models\Article */
use common\helpers\Html;

?>
<div class="article-create">

    <h4>留言</h4>

    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('suggest/create')]); ?>
    <?= $form->field($model, 'content')->label(false)->widget('\yidashi\markdown\Markdown', ['options' => ['style' => 'height:200px;']]); ?>
    <div class="form-group">
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        <?php else: ?>
            <?= Html::a('登录', ['/site/login'], ['class' => 'btn btn-primary'])?>
        <?php endif; ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
