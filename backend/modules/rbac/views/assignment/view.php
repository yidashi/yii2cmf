<?php

use rbac\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model yii\web\IdentityInterface */

$this->title = Yii::t('rbac', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">
    <?= Html::a(Yii::t('rbac', 'Users'), ['index'], ['class' => 'btn btn-success btn-flat']) ?>

    <div class="row">
        <div class="col-lg-5">
            <?= Yii::t('rbac', 'Avaliable') ?>:
            <input id="search-avaliable"><br>
            <select id="list-avaliable" multiple size="20" style="width: 100%">
            </select>
        </div>
        <div class="col-lg-1">
            <br><br>
            <a href="#" id="btn-assign" class="btn btn-success btn-flat">&gt;&gt;</a><br>
            <a href="#" id="btn-revoke" class="btn btn-danger">&lt;&lt;</a>
        </div>
        <div class="col-lg-5">
            <?= Yii::t('rbac', 'Assigned') ?>:
            <input id="search-assigned"><br>
            <select id="list-assigned" multiple size="20" style="width: 100%">
            </select>
        </div>
    </div>
</div>
<?php
AdminAsset::register($this);
$properties = Json::htmlEncode([
        'userId' => $model->{$idField},
        'assignUrl' => Url::to(['assign']),
        'searchUrl' => Url::to(['search']),
    ]);
$js = <<<JS
yii.admin.initProperties({$properties});

$('#search-avaliable').keydown(function () {
    yii.admin.searchAssignmet('avaliable');
});
$('#search-assigned').keydown(function () {
    yii.admin.searchAssignmet('assigned');
});
$('#btn-assign').click(function () {
    yii.admin.assign('assign');
    return false;
});
$('#btn-revoke').click(function () {
    yii.admin.assign('revoke');
    return false;
});

yii.admin.searchAssignmet('avaliable', true);
yii.admin.searchAssignmet('assigned', true);
JS;
$this->registerJs($js);
