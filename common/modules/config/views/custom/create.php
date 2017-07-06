<?php


/* @var $this yii\web\View */
/* @var $model common\modules\config\models\Config */

$this->title = '新建配置';
$this->params['breadcrumbs'][] = ['label' => '配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
