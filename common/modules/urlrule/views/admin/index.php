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
                        'pattern',
                        'route',
                        'defaults',
                        'suffix',
                        'verb',
                        [
                            'class' => 'yii\grid\ActionColumn',
                        ]
                    ]
                ]
                );
                ?>
			</div>
		</div>
	</div>

</div>


