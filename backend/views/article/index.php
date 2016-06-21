<?php

use common\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-header"><h2 class="box-title">文章搜索</h2></div>
        <div class="box-body"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
    </div>
    <div class="box box-primary">
        <div class="box-header"><h2 class="box-title">文章列表</h2></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'title',
                        'value' => function($model) {
                            return Html::a($model->title, env('FRONTEND_URL') . '/' . $model->id . '.html', ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    'category',
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            $arr = Yii::$app->formatter->booleanFormat;
                            return Html::a($model->status ? $arr[1] : $arr[0], 'javascript:;', ['onclick' => "changeStatus(this)", 'data-id' => $model->id, 'data-status' => $model->status]);
                        },
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php $this->beginBlock('js'); ?>
<script>
function changeStatus(ele)
{
    var url = "<?= \yii\helpers\Url::to(['/article/change-status']) ?>";
    ele = $(ele);
    var id = ele.data('id'),status = ele.data('status');
    $.post(url,{id:id,status:status}, function(res){
        if (res.status == 1) {
            if (status == 1) {
                ele.find('span').removeClass('label-success').addClass('label-danger').find('i').removeClass('fa-check').addClass('fa-times');
                ele.data('status', 0);
            } else {
                ele.find('span').removeClass('label-danger').addClass('label-success').find('i').removeClass('fa-times').addClass('fa-check');
                ele.data('status', 1);
            }
        }
    })
}
</script>
<?php $this->endBlock() ?>
) ?>
