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
$this->params['breadcrumbs'][] = ['label' => 'wiki', 'url' => ['/book/default/index']];
$this->params['breadcrumbs'][] = Html::encode($model->book_name);
?>
<?php $this->beginContent('@common/modules/book/views/default/_layout.php', ['book' => $model]) ?>
<div class="view-title">
    <h1><?= Html::encode($model->book_name) ?></h1>
</div>
<div class="view-content"><?= HtmlPurifier::process(Markdown::process($model->book_description)) ?></div>
<!--分享-->
<?= \common\widgets\share\Share::widget()?>
<!-- 评论   -->
<?= \frontend\widgets\comment\CommentWidget::widget(['model' => $model]) ?>
<?php $this->endContent() ?>
<?php $this->registerJs("$('.view-content a').attr('target', '_blank');") ?>