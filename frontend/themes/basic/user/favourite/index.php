<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/25
 * Time: 下午8:57.
 */
$this->title = '我收藏的';
$this->params['breadcrumbs'][] = $this->title;
/* @var $this \yii\web\View */
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('../_menu') ?>
        </div>
        <div class="col-md-9">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'layout' => "{items}\n{pager}",
                'itemOptions' => [
                    'tag' => 'li',
                ],
                'options' => [
                    'tag' => 'ul',
                    'class' => 'post-list'
                ]
            ]) ?>
        </div>
    </div>
</div>
