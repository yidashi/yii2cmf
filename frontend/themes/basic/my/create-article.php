<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $dataModel common\models\ArticleData */

$this->title = '投稿_'.Yii::$app->params['seoTitle'].Yii::$app->params['seoSeparator'].Yii::$app->name;
$this->params['breadcrumbs'][] = '投稿';
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataModel' => $dataModel,
    ]) ?>

</div>
