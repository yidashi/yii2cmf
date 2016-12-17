<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午2:20
 */
/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use backend\widgets\ActiveForm;

$this->title = '编辑书:' . $model->book_name;
$this->params['breadcrumbs'][] = ['label' => '书', 'url' => ['/book/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model' => $model]) ?>