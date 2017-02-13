<?php


/* @var $this yii\web\View */
/* @var $model common\modules\config\models\Config */

$this->title = \Yii::t('app', 'Create Config');
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
