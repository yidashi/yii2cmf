<?php

use yii\helpers\Html;
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
                    'title',
                    'category',
                    'status:boolean',
                    // 'author',
                    // 'created_at',
                    // 'updated_at',
                    // 'status',
                    // 'cover',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
