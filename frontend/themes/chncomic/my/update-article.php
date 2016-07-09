<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\ArticleForm */

$this->title = '我的投稿_' . Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => '我的投稿', 'url' => ['/my/article-list']];
$this->params['breadcrumbs'][] = $model->title;

?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
