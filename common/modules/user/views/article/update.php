<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = '我的发布';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/user/article-list']];
$this->params['breadcrumbs'][] = $model->title;

?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'moduleModel' => $moduleModel
    ]) ?>

</div>
