<?php

/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = '修改标签: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '标签', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
