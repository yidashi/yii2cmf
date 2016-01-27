<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/25
 * Time: 下午8:57.
 */
$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="post-list">
    <?php foreach ($models as $key => $item):?>
    <li>
        <a href="<?php if ($item->status == 1):?><?=\yii\helpers\Url::to(['/article/view', 'id' => $item->id])?><?php else:?><?=\yii\helpers\Url::to(['/my/update-article', 'id' => $item->id])?><?php endif;?>"><?=$item->title?></a>
        <span class="pull-right"><?php if ($item->status == 1):?>审核通过<?php else:?>未审核<?php endif;?></span>
        </li>
    <?php endforeach;?>
</ul>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]); ?>
