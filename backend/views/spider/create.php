<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = 'Create Spider';
$this->params['breadcrumbs'][] = ['label' => 'Spiders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
