<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午2:20
 */
/**
 * @var \yii\web\View $this
 * @var \common\modules\book\models\BookChapter $model
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use backend\widgets\ActiveForm;

$this->title = $model->chapter_name;
$this->params['breadcrumbs'][] = ['label' => '书', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book->book_name, 'url' => ['view', 'id' => $model->book->id]];
$this->params['breadcrumbs'][] = Html::encode($model->chapter_name);
?>
<?php $this->beginContent('@common/modules/book/views/admin/_layout.php', ['model' => $model]) ?>
<?= $this->render('_form_chapter', ['model' => $model]) ?>
<?php $this->endContent() ?>
