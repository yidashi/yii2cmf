<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\ArticleForm */

$this->title = '投稿_'.Yii::$app->config->get('SITE_NAME');
$this->params['breadcrumbs'][] = '投稿';
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
