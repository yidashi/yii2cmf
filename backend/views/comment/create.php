<?php


/* @var $this yii\web\View */
/* @var $model common\models\Config */

$this->title = \Yii::t('app', 'Create Comment');
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
