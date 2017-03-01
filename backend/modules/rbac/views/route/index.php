<?php

use rbac\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/*
 * @var yii\web\View $this
 */
$this->title = Yii::t('rbac', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a(Yii::t('app', '新路由'), ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>

<div class="box box-primary">
    <div class="box-body">
        <div class="col-xs-5">
            <?= Yii::t('rbac', 'Avaliable') ?>:
            <input id="search-avaliable">
            <a href="#" id="btn-refresh"><span class="glyphicon glyphicon-refresh"></span></a><br><br>
            <select id="list-avaliable" multiple size="20" style="width: 100%">
            </select>
        </div>
        <div class="col-xs-1">
            <br><br>
            <a href="#" id="btn-add" class="btn btn-success btn-flat">&gt;&gt;</a><br>
            <a href="#" id="btn-remove" class="btn btn-danger">&lt;&lt;</a>
        </div>
        <div class="col-xs-5">
            <?= Yii::t('rbac', 'Assigned') ?>:
            <input id="search-assigned"><br><br>
            <select id="list-assigned" multiple size="20" style="width: 100%">
            </select>
        </div>
    </div>
</div>
<?php
AdminAsset::register($this);
$properties = Json::htmlEncode([
        'assignUrl' => Url::to(['assign']),
        'searchUrl' => Url::to(['search']),
    ]);
$js = <<<JS
yii.admin.initProperties({$properties});

$('#search-avaliable').keydown(function () {
    yii.admin.searchRoute('avaliable');
});
$('#search-assigned').keydown(function () {
    yii.admin.searchRoute('assigned');
});
$('#btn-add').click(function () {
    yii.admin.assignRoute('assign');
    return false;
});
$('#btn-remove').click(function () {
    yii.admin.assignRoute('remove');
    return false;
});
$('#btn-refresh').click(function () {
    yii.admin.searchRoute('avaliable',1);
    return false;
});

yii.admin.searchRoute('avaliable', 0, true);
yii.admin.searchRoute('assigned', 0, true);
JS;
$this->registerJs($js);
