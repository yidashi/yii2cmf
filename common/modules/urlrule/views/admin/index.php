<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/**
 *
 * @var $this \yii\web\View
 */
/**
 *
 * @var $model \yii\db\ActiveRecord
 */
/**
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = '路由规则';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
	<div class="col-md-4">
		<?= $this->render('_form', ['model' => $model]) ?>
	</div>
	<div class="col-md-8">
		<div class="box box-solid">
			<div class="box-body no-padding">
				 <?= GridView::widget([
                    'layout' => "{items}",
                    'dataProvider' => $dataProvider,
                    "columns" => [
                        'id',
                        [
                            'attribute' => 'pattern',
                            "format" => "html",
                            'value' => function ($model, $key, $index, $column) {
                                $params = is_array($key) ? $key : [
                                    'id' => (string) $key
                                ];
                                $params[0] = "update";
                                $value = ArrayHelper::getValue($model, $column->attribute);
                                return Html::a($value, $params);
                            }
                        ],
                        'route',
                        'defaults',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            "urlCreator" => function ($action, $model, $key, $index) {
                                if ($action != "view") {
                                    return null;
                                }

                                $route = $model->route;
                                parse_str($model->defaults, $params);
                                array_unshift($params, $route);
                                return \Yii::$app->urlManager->createUrl($params);
                            }
                        ]
                    ]
                ]
                );
                ?>
			</div>
		</div>
	</div>

</div>


