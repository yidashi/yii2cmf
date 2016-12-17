<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午3:14
 */

/**
 * @var \yii\web\View $this
 * @var common\models\BookChapter $model
 */
?>
<div class="row">
    <div class="col-md-3">
        <?= \frontend\widgets\SideNavWidget::widget([
            'items' => $model->book->getUpdateMenuItems()
        ]) ?>

        <?= \yii\helpers\Html::a('新增章节', ['/book/create-chapter', 'id' => $model->book->id], ['class' => 'btn bg-maroon btn-lg']) ?>
        <?php if (!$model->isNewRecord): ?>
        <?= \yii\helpers\Html::a('新增子章节', ['/book/create-chapter', 'id' => $model->book->id, 'chapter_id' => $model->id], ['class' => 'btn bg-maroon btn-lg']) ?>
        <?php endif; ?>
    </div>
    <div class="col-md-9">
        <div class="box box-solid">
            <div class="box-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
