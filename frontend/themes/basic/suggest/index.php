<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/31
 * Time: 下午5:33
 */

?>
<div class="col-4">
    <ul class="media-list">
        <?= \yii\widgets\ListView::widget([
            'itemView' => '_item',
            'dataProvider' => $dataProvider
        ])?>
    </ul>

    <?= $this->render('create', ['model' => $model]); ?>
</div>
