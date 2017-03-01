<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */
/* @var $this \yii\web\View */

$this->title = '留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \frontend\widgets\comment\CommentWidget::widget([
    'entity' => 'suggest',
    'entityId' => 1,
    'listTitle' => '留言',
    'createTitle' => '留言'
]) ?>
