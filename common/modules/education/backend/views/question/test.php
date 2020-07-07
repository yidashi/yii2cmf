<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/7/4
 * Time: 11:05 上午
 */

use yii\bootstrap\Html;

/**
 * @var $this \yii\web\View
 */
?>
<?= Html::beginForm(['test2'], 'post', ['id' => 'form']) ?>
<?= \common\widgets\editor\ueditor\UEditor::widget([
    'name' => 'content',
    'clientOptions' => [
        'toolbars' => [[
            'kityformula'
        ]]
    ]
]) ?>
<?= Html::submitButton() ?>
<?php Html::endForm() ?>