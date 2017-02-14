<?php
$this->title = '修改区块';
$this->params['breadcrumbs'][] = ["label"=>"区块列表","url"=>["index"]];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= $this->render("_form", ['model' => $model])?>