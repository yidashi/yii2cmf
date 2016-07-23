<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$contexts = $generator->getContexts();

echo "<?php\n";
?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
use yii\grid\GridView;
use yii2tech\admin\grid\ActionColumn;
<?php else: ?>
use yii\widgets\ListView;
<?php endif ?>
<?php if (!empty($contexts)): ?>
use yii\helpers\Url;
<?php endif ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */
<?php if (!empty($contexts)): ?>
/* @var $controller <?= $generator->controllerClass ?>|yii2tech\admin\behaviors\ContextModelControlBehavior */

$controller = $this->context;
$contextUrlParams = $controller->getContextQueryParams();
<?php endif ?>

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
<?php if (!empty($contexts)): ?>
foreach ($controller->getContextModels() as $name => $contextModel) {
    $this->params['breadcrumbs'][] = ['label' => $name, 'url' => $controller->getContextUrl($name)];
    $this->params['breadcrumbs'][] = ['label' => $contextModel->id, 'url' => $controller->getContextModelUrl($name)];
}
<?php endif ?>
$this->params['breadcrumbs'][] = $this->title;
<?php if (!empty($contexts)): ?>
$this->params['contextMenuItems'] = [
    array_merge(['create'], $contextUrlParams)
];
<?php else: ?>
$this->params['contextMenuItems'] = [
    ['create']
];
<?php endif ?>
?>
<?php if (!empty($generator->searchModelClass) && $generator->indexWidgetType !== 'grid'): ?>
<?= "\n    <?php " ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
<?= "<?= " ?>GridView::widget([
    'dataProvider' => $dataProvider,
    <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n    'columns' => [\n" : "'columns' => [\n"; ?>
        ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "        '" . $name . "',\n";
        } else {
            echo "        // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "        // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

        [
            'class' => ActionColumn::className(),
        ],
    ],
]); ?>
<?php else: ?>
<?= "<?= " ?>ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model-><?= $nameAttribute ?>), array_merge(['view', <?= $urlParams ?>], $contextUrlParams));
    },
]) ?>
<?php endif; ?>
