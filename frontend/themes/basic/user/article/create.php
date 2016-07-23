<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57.
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */
/* @var $dataModel common\models\ArticleData */

$this->title = '投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataModel' => $dataModel
    ]) ?>

</div>
