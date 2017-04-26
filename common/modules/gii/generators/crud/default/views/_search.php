<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title"><?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>搜索</h2>
        <div class="box-tools"><button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-original-title="" title=""><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body">

        <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        ]); ?>

        <?php
        $count = 0;
        foreach ($generator->getColumnNames() as $attribute) {
            if (++$count < 6) {
                echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
            } else {
                echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
            }
        }
        ?>
        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary btn-flat']) ?>
            <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default btn-flat']) ?>
        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>

    </div>
</div>
