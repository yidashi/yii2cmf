<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据备份';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">
    <?php \yii\widgets\ActiveForm::begin(['id' => 'export-form', 'action' => ['init']])?>
    <p>
        <?= Html::a('立即备份', ['init'], ['class' => 'btn btn-success btn-flat', 'id' => 'export']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => \yii\grid\CheckboxColumn::className(),
                        'name' => 'tables',
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['name']];
                        }
                    ],
                    'name:text:表名',
                    'rows:text:数据量',
                    [
                        'attribute' => 'data_length',
                        'label' => '数据大小',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asShortSize($model['data_length']);
                        }
                    ],
                    'create_time:text:创建时间',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{a} {b}',
                        'buttons' => [
                            'a' => function ($url, $model, $key) {
                                return Html::a('优化表',
                                    ['export/optimize', 'tables' => $model['name']],
                                    [
                                        'data' => [
                                            'ajax' => 1,
                                            'method' => 'get'
                                        ],
                                        'class' => 'btn btn-default btn-xs'
                                    ]
                                );
                            },
                            'b' => function ($url, $model, $key) {
                                return Html::a('修复表',
                                    ['export/repair', 'tables' => $model['name']],
                                    [
                                        'data' => [
                                            'ajax' => 1,
                                            'method' => 'get'
                                        ],
                                        'class' => 'btn btn-default btn-xs'
                                    ]
                                );
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php \yii\widgets\ActiveForm::end()?>
        </div>
    </div>
</div>
<?php $this->beginBlock('js'); ?>
<!-- /应用列表 -->
<script type="text/javascript">
    (function($){
        var $form = $("#export-form"), $export = $("#export"), tables
        $optimize = $("#optimize"), $repair = $("#repair");

        $optimize.add($repair).click(function(){
            $.post(this.href, $form.serialize(), function(data){
                if(data.status){
                    $.modal.success(data.info);
                } else {
                    $.modal.error(data.info);
                }
                setTimeout(function(){
                    $('#top-alert').find('button').click();
                    $(that).removeClass('disabled').prop('disabled',false);
                },1500);
            }, "json");
            return false;
        });

        $export.click(function(){
            $export.parent().children().addClass("disabled");
            $export.html("正在发送备份请求...");
            var that = this;
            $.post(
                $form.attr("action"),
                $form.serialize(),
                function(data){
                    if(data.status){
                        tables = data.tables;
                        $export.html(data.info + "开始备份，请不要关闭本页面！");
                        backup.call(that, data.tab);
                        window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                    } else {
                        $.modal.error(data.info);
                        $export.parent().children().removeClass("disabled");
                        $export.html("立即备份");
                        setTimeout(function(){
                            $(that).removeClass('disabled').prop('disabled',false);
                        },1500);
                    }
                },
                "json"
            );
            return false;
        });

        function backup(tab, status){
            status && showmsg(tab.id, "开始备份...(0%)");
            $.post('<?= \yii\helpers\Url::to(['start'])?>', tab, function(data){
                if(data.status){
                    showmsg(tab.id, data.info);

                    if(!$.isPlainObject(data.tab)){
                        $export.parent().children().removeClass("disabled");
                        $export.html("备份完成，点击重新备份");
                        window.onbeforeunload = function(){ return null }
                        return;
                    }
                    backup(data.tab, tab.id != data.tab.id);
                } else {
                    $.modal.error(data.info);
                    $export.parent().children().removeClass("disabled");
                    $export.html("立即备份");
                    setTimeout(function(){
                        $(this).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }, "json");

        }

        function showmsg(id, msg){
            $form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
        }
    })(jQuery);
</script>
<?php $this->endBlock('js'); ?>
