<?php


/* @var $this yii\web\View */
/* @var $model common\models\Spider */

$this->title = Yii::t('app', 'Create Spider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spiders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
