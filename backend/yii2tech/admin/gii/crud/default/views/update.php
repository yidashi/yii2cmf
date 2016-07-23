<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$contexts = $generator->getContexts();

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?php if (!empty($contexts)): ?>
/* @var $controller <?= $generator->controllerClass ?>|yii2tech\admin\behaviors\ContextModelControlBehavior */

$controller = $this->context;
$contextUrlParams = $controller->getContextQueryParams();
<?php endif ?>

$this->title = <?= $generator->generateString('Update ' . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ': ') ?> . $model-><?= $generator->getNameAttribute() ?>;
<?php if (!empty($contexts)): ?>
foreach ($controller->getContextModels() as $name => $contextModel) {
    $this->params['breadcrumbs'][] = ['label' => $name, 'url' => $controller->getContextUrl($name)];
    $this->params['breadcrumbs'][] = ['label' => $contextModel->id, 'url' => $controller->getContextModelUrl($name)];
}
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => array_merge(['index'], $contextUrlParams)];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => array_merge(['view', <?= $urlParams ?>], $contextUrlParams)];
<?php else: ?>
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
<?php endif ?>
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>

<?= "<?= " ?>$this->render('_form', [
    'model' => $model,
]) ?>


