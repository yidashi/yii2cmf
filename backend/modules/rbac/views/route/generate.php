<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 */

$this->title = Yii::t('rbac', 'Generate Routes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Routes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
echo Html::beginForm();
echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $new,
            ]),
    'columns' => [
        [
            'class' => 'yii\\grid\\CheckboxColumn',
            'checkboxOptions' => function ($model) {
                return [
                    'value' => ArrayHelper::getValue($model, 'name'),
                    'checked' => true,
                ];
            },
        ],
        [
            'class' => 'yii\\grid\\DataColumn',
            'attribute' => 'name',
        ],
    ],
]);
echo Html::submitButton(Yii::t('rbac', 'Append'), ['name' => 'Submit', 'class' => 'btn btn-primary btn-flat']);
echo Html::endForm();
?>
