<?php


/* @var $this yii\web\View */
/* @var $model common\models\Config */

$this->title = '修改评论: '.' '.$model->id;
$this->params['breadcrumbs'][] = ['label' => '评论', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="config-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
