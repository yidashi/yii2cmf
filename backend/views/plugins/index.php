<?php

use common\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = '插件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-index">

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'name:text:标识',
                    'title:text:名字',
                    'version:text:版本',
                    'author:text:作者',
                    'status:boolean:是否启用',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{open} {close} {install} {uninstall}',
                        'buttons' => [
                            'open' => function($url, $model, $key) {
                                if ($model['install'] == 0) {
                                    return false;
                                }
                                if ($model['status'] == 1) {
                                    return false;
                                }
                                return Html::a('开启', ['open'], [
                                    'data-method' => 'post',
                                    'data-params' => ['name' => $model['name']]
                                ]);
                            },
                            'close' => function($url, $model, $key) {
                                if ($model['install'] == 0) {
                                    return false;
                                }
                                if ($model['status'] == 0) {
                                    return false;
                                }
                                return Html::a('关闭', ['close'], [
                                    'data-method' => 'post',
                                    'data-params' => ['name' => $model['name']]
                                ]);
                            },
                            'install' => function($url, $model, $key) {
                                if ($model['install'] == 1) {
                                    return false;
                                }
                                return Html::a('安装', ['install'], [
                                    'data-method' => 'post',
                                    'data-params' => ['name' => $model['name']]
                                ]);
                            },
                            'uninstall' => function($url, $model, $key) {
                                if ($model['install'] == 0) {
                                    return false;
                                }
                                return Html::a('卸载', ['uninstall'], [
                                    'data-method' => 'post',
                                    'data-confirm' => '确定要卸载该插件吗?',
                                    'data-params' => ['name' => $model['name']]
                                ]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
