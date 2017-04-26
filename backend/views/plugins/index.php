<?php

use yii\grid\GridView;
use yii\helpers\Html;

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
                    'package:text:ID',
                    'name:text:名字',
                    'version:text:版本',
                    'author:text:作者',
                    'open:boolean:是否启用',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{open} {close} {install} {uninstall} {config}',
                        'buttons' => [
                            'open' => function($url, $model, $key) {
                                if (!$model->install) {
                                    return false;
                                }
                                if ($model->open) {
                                    return false;
                                }
                                return Html::a('开启', ['open'], [
                                    'data-method' => 'post',
                                    'data-params' => ['id' => $model->package],
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            },
                            'close' => function($url, $model, $key) {
                                if (!$model->install) {
                                    return false;
                                }
                                if (!$model->open) {
                                    return false;
                                }
                                return Html::a('关闭', ['close'], [
                                    'data-method' => 'post',
                                    'data-params' => ['id' => $model->package],
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            },
                            'install' => function($url, $model, $key) {
                                if ($model->install) {
                                    return false;
                                }
                                return Html::a('安装', ['install'], [
                                    'data-method' => 'post',
                                    'data-params' => ['id' => $model->package],
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            },
                            'uninstall' => function($url, $model, $key) {
                                if (!$model->install) {
                                    return false;
                                }
                                return Html::a('卸载', ['uninstall'], [
                                    'data-method' => 'post',
                                    'data-confirm' => '确定要卸载该插件吗?',
                                    'data-params' => ['id' => $model->package],
                                    'class' => 'btn btn-default btn-xs'
                                ]);
                            },
                            'config' => function($url, $model, $key) {
                                if (!$model->install || empty($model->config)) {
                                    return false;
                                }
                                return Html::a('配置', ['config', 'id' => $model->package], ['class' => 'btn btn-default btn-xs']);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
