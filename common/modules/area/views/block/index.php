<?php
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = '区块';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('content-header'); ?>
<h1>
	<?= $this->title?> <a class="btn btn-primary btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>">新区块
	</a>
</h1>
<?php $this->endBlock(); ?>




<div class="box box-primary">
	<div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            "columns"=>[
                'block_id',
                [
                   'attribute' => 'title',
                    "format"=>"html",
                    'value'=>function($model, $key, $index, $column)
                    {
                         $params = is_array($key) ? $key : ['id' => (string) $key];
                         $params[0] = "update";
                         $value =  ArrayHelper::getValue($model, $column->attribute);
                         return Html::a($value,$params);
                    }
                ],
                'slug',
                'type',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>"{update} {delete}"
                ]
            ]

        ]);
        ?>
	</div>
</div>