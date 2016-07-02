<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Module */

$this->title = Yii::t('app', 'Create Module');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
