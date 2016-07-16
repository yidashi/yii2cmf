<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 下午1:43
 */

$this->title = '签到会员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h2>今日签到会员</h2>
            <span class="pull-right">
<!--                昨日签到：<font style="font-weight: bold; color: red; margin-right: 20px;">174</font>-->
<!--                上周同期：<font style="font-weight: bold; color: red; margin-right: 20px;">171</font>-->
                今日签到：<font style="font-weight: bold; color: red;"><?= $dataProvider->getTotalCount() ?></font>
            </span>
</div>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}",
    'itemView' => '_item',
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'media col-lg-4 col-md-4',
        'style' => 'float: left; margin-bottom: 15px; font-size: 12px; margin-top: 0;'
    ],
    'options' => [
        'tag' => 'ul',
        'class' => 'media-list registration'
    ]
]) ?>
