<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model plugins\donation\models\Donation */

$this->title = '新捐赠';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
