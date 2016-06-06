<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */

?>
<div class="col-4">
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'viewParams' => [
            'commentModel' => $model
        ],
        'itemView' => '_item',
        'itemOptions' => [
            'class' => 'media',
            'tag' => 'li'
        ],
        'options' => [
            'class' => 'media-list',
            'tag' => 'ul'
        ]
    ])?>

    <?= $this->render('create', ['model' => $model]); ?>
</div>
