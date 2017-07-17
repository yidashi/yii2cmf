<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = '留言';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="clearfix">
        <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="pull-right btn btn-primary">留言</a>
    </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => "{items}",
            'options' => ['class' => 'article-list'],
            'itemOptions' => ['class' => 'media']
        ]) ?>
        <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->getPagination()
        ]) ?>
