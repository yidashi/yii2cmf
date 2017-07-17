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
$this->title = '我的私信';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="clearfix">
<a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-success btn-sm pull-right"><?= \yii\helpers\Html::icon('plus') ?> 发新私信</a>
</div>
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
