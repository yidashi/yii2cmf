<?php
/**
 * @var $this yii\web\View
 */
?>
<style>
    .media-content img{width:80px;height:80px;margin-right:10px;}
</style>
<div id="comments">
    <h4>共 <span class="text-danger"><?= $commentTotal ?></span> 条<?= $listTitle ?></h4>
    <?php \yii\widgets\Pjax::begin(['id' => 'comment-container']) ?>
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "{items}\n{pager}",
        'itemOptions' => [
            'class' => 'media',
            'tag' => 'li'
        ],
        'options' => [
            'class' => 'media-list',
            'tag' => 'ul'
        ],
        'emptyText' => ''
    ])?>
    <?= $this->render('create', ['model' => $commentModel, 'createTitle' => $createTitle]); ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
<?php $this->beginBlock('js') ?>
<script>
    layer.ready(function () {
        layer.photos({
            photos:'.media-content',
            shift:5
        });
    })
</script>
<?php $this->endBlock() ?>
<?php $this->trigger('afterComment', new \frontend\widgets\comment\CommentEvent(['entity' => $entity, 'entityId' => $entityId])) ?>
