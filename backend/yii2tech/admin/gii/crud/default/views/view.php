<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$contexts = $generator->getContexts();

echo "<?php\n";
?>

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?php if (!empty($contexts)): ?>
/* @var $controller <?= $generator->controllerClass ?>|yii2tech\admin\behaviors\ContextModelControlBehavior */

$controller = $this->context;
$contextUrlParams = $controller->getContextQueryParams();
<?php endif ?>

$this->title = $model-><?= $generator->getNameAttribute() ?>;
<?php if (!empty($contexts)): ?>
foreach ($controller->getContextModels() as $name => $contextModel) {
    $this->params['breadcrumbs'][] = ['label' => $name, 'url' => $controller->getContextUrl($name)];
    $this->params['breadcrumbs'][] = ['label' => $contextModel->id, 'url' => $controller->getContextModelUrl($name)];
}
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => array_merge(['index'], $contextUrlParams)];
<?php else: ?>
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
<?php endif ?>
$this->params['breadcrumbs'][] = $this->title;
<?php if (!empty($contexts)): ?>
$this->params['contextMenuItems'] = [
    array_merge(['update', <?= $urlParams ?>], $contextUrlParams),
    array_merge(['delete', <?= $urlParams ?>], $contextUrlParams)
];
<?php else: ?>
$this->params['contextMenuItems'] = [
    ['update', <?= $urlParams ?>],
    ['delete', <?= $urlParams ?>]
];
<?php endif ?>
?>
<div class="row">
    <div class="col-lg-8">
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>
    </div>
</div>