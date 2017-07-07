<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午3:14
 */

/**
 * @var \yii\web\View $this
 * @var common\modules\book\models\Book $book
 */
?>
<div class="row">
    <div class="col-md-3">
        <?= \common\widgets\SideNavWidget::widget([
            'items' => $book->getMenuItems()
        ]) ?>
    </div>
    <div class="col-md-9">
        <?= $content ?>
    </div>
</div>
