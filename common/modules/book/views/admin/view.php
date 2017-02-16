<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午2:20
 */
/**
 * @var \yii\web\View $this
 * @var \common\modules\book\models\Book $model
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

$this->title = $model->book_name;
$this->params['breadcrumbs'][] = ['label' => '书', 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($model->book_name);
?>
    <div class="view-title">
        <h1><?= Html::encode($model->book_name) ?></h1>
    </div>
    <div class="view-content"><?= HtmlPurifier::process(Markdown::process($model->book_description)) ?></div>
