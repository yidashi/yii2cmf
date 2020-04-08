<?php

use common\modules\document\models\DocumentModule;

/* @var $this yii\web\View */
/* @var $model DocumentModule */

$this->title = '修改内容模型: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
