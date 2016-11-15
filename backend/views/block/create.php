<?php

$this->title = '新建区块';
$this->params['breadcrumbs'][] = ["label"=>"区块列表","url"=>["index"]];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php echo $this->render("_form",["model"=>$model])?>