<?php
/**
 * author: yidashi
 * Date: 2015/12/3
 * Time: 10:57
 */
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = '投稿_' . Yii::$app->name;
$this->params['breadcrumbs'][] = '投稿';
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
