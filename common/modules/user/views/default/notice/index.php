<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:45
 */
/**
 * @var $this \yii\web\View;
 */
$this->title = '我的通知';
$this->params['breadcrumbs'][] = $this->title;
?>
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'layout' => "{items}\n{pager}",
                'itemOptions' => [
                    'label' => 'li',
                    'class' => 'media'
                ],
                'options' => [
                    'label' => 'ul',
                    'class' => 'media-list'
                ]
            ]) ?>
