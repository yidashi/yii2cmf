<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */
/* @var $this \yii\web\View */
/* @var $model \common\models\Suggest */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '留言';
$this->params['breadcrumbs'][] = ['label' => '留言', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="view-title">
    <h1><?= Html::encode($model->title) ?></h1>
</div>
<div class="action">
    <span class="user"><a href="<?= Url::to(['/user/default/index', 'id' => $model->user_id]) ?>"><?= Html::icon('user')?> <?= Html::encode($model->user->username) ?></a></span>
    <span class="time"><?= Html::icon('clock-o')?> <?= date('Y-m-d', $model->created_at) ?></span>
</div>
<div class="view-content"><?= \yii\helpers\HtmlPurifier::process(\yii\helpers\Markdown::process($model->content)) ?></div>
<?= \frontend\widgets\comment\CommentWidget::widget([
    'model' => $model
]) ?>
