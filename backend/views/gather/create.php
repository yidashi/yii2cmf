<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Gather */

$this->title = 'Create Gather';
$this->params['breadcrumbs'][] = ['label' => 'Gathers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gather-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
