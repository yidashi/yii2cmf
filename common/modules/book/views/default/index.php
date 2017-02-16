<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午8:59
 */

/**
 * @var \yii\web\View $this
 */
$this->title = 'wiki';
$this->params['breadcrumbs'][] = 'wiki';
?>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => '{items} {pager}',
    'options' => [
        'class' => 'row'
    ],
    'itemOptions' => [
        'class' => 'col-xs-3'
    ],
]) ?>

