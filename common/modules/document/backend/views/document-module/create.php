<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \common\modules\document\models\DocumentModule */

$this->title = '新增内容模型';
$this->params['breadcrumbs'][] = ['label' => '内容模型', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-module-create">
    <div class="alert alert-info">
        需要创建`common\modules\document\models\document\标识`类，并添加`DynamicFormBehavior`行为控制字段表单类型，参考`common\modules\document\models\document\Article`
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
