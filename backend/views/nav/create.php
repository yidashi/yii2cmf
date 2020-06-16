<?php
/* @var $this yii\web\View */

$this->title = '新建导航';
$this->params['breadcrumbs'][] = ['label' => '导航', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-Nav-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
