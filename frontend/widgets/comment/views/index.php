<div id="comments">
    <h4>共 <span class="text-danger"><?= $comment ?></span> 条<?= $listTitle ?></h4>
    <div class="col-4">
        <ul class="media-list">
        </ul>
    </div>
</div>
<div class="col-4">
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
        ]
    ])?>

    <?= $this->render('create', ['model' => $commentModel, 'createTitle' => $createTitle]); ?>
</div>
<?php $this->trigger('afterComment') ?>
