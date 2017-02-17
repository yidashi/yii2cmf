<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ArticleModule */

$this->title = 'Create Article Module';
$this->params['breadcrumbs'][] = ['label' => 'Article Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-module-create">
    <div class="alert alert-info">
        需要创建`common\models\article\Name`类，并添加`DynamicFormBehavior`行为控制字段表单类型，参考`common\models\article\Base`
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
