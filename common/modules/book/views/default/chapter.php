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

$this->title = $model->chapter_name;
$this->params['breadcrumbs'][] = ['label' => 'wiki', 'url' => ['/book/default/index']];
$this->params['breadcrumbs'][] = ['label' => $model->book->book_name, 'url' => ['/book/default/view', 'id' => $model->book->id]];
$this->params['breadcrumbs'][] = Html::encode($model->chapter_name);
?>
<?php $this->beginContent('@common/modules/book/views/default/_layout.php', ['book' => $model->book]) ?>
<div class="view-title">
    <h1><?= Html::encode($model->chapter_name) ?></h1>
</div>
<div class="view-content"><?= HtmlPurifier::process(Markdown::process($model->chapter_body)) ?></div>
<!-- 评论   -->
<?= \frontend\widgets\comment\CommentWidget::widget(['model' => $model]) ?>
<?php $this->endContent() ?>
<?php $this->registerJs("$('.view-content a').attr('target', '_blank');") ?>