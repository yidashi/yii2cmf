<?php

use common\modules\document\models\DocumentModule;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \common\modules\document\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '内容管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('发布内容', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'id' => 'article-grid',
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'title',
                        'value' => function($model) {
                            return Html::a($model->title, Yii::$app->config->get('SITE_URL') . '/' . $model->id . '.html', ['target' => '_blank', 'no-iframe' => '1']);
                        },
                        'format' => 'raw',
                        'enableSorting' => false
                    ],
                    'category.title:text:分类',
                    [
                        'label' => '标签',
                        'value' => function ($model) {
                            $html = '';
                            foreach ($model->tags as $tag) {
                                $html .= ' <span class="label label-' . $tag->level . '">' . $tag->name . '</span>';
                            }
                            return $html;
                        },
                        'format' => 'raw'
                    ],
                    'trueView',
                    [
                        'class' => 'backend\widgets\grid\SwitcherColumn',
                        'attribute' => 'is_top'
                    ],
                    [
                        'class' => 'backend\widgets\grid\SwitcherColumn',
                        'attribute' => 'status'
                    ],
                    'user_id:admin',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete} {refresh}',
                        'buttons' => [
                            'refresh' => function ($url, $model, $key) {
                                return Html::a('刷新', $url, ['class' => 'btn btn-primary btn-xs']);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
