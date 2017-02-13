<?php


/* @var $this yii\web\View */
/* @var $model common\modules\config\models\Config */

$this->title = '更新配置: '.' '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="config-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
