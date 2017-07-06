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
