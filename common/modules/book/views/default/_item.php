<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午9:00
 */
/**
 * @var common\modules\book\models\Book $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="thumbnail">
    <a href="<?php if($model->book_link) {echo $model->book_link;}else {echo url(['view', 'id' => $model->id]);} ?>" <?php if($model->book_link){echo 'target="_blank"';} ?>>
        <img alt="<?= Html::encode($model->book_name) ?>" src="<?= $model->book_cover ?>"/>
        <div class="caption">
            <h3><?= Html::encode($model->book_name) ?></h3>
            <p>阅读/<?= $model->view ?> 评论/<?= $model->getAllCommentTotal() ?></p>
        </div>
    </a>
</div>
