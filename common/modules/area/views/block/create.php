<?php

$this->title = '新建区块';
$this->params['breadcrumbs'][] = ["label"=>"区块列表","url"=>["index"]];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">区块列表</h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding" style="display: block;">
                <?= \yii\bootstrap\Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => '文本块', 'url' => ['create', 'type' => 'text'], 'active' => $model->type == 'text'],
                        ['label' => '文章块', 'url' => ['create', 'type' => 'article'], 'active' => $model->type == 'article'],
                    ],
                ]) ?>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <div class="col-md-9">
    <?php echo $this->render("_form", ['model' => $model])?>
    </div>
</div>
