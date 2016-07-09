<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/25
 * Time: 下午8:57.
 */
$this->title = '我收藏的';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($dataProvider) :?>
<ul class="post-list">
    <?php foreach ($dataProvider->getModels() as $key => $item):?>
    <li>
        <a href="<?=\yii\helpers\Url::to(['/article/view', 'id' => $item->article->id])?>"><?=$item->article->title?></a>
        <?= \common\helpers\Html::a('取消', ['/favourite'], [
                'data' => [
                    'method' => 'post',
                    'ajax' => 1,
                    'params' => [
                        'id' => $item->article->id
                    ],
                    'confirm' => '确定要取消收藏吗?',
                ],
                'class' => 'text-danger pull-right'
            ])?>
    </li>
    <?php endforeach;?>
</ul>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
]); ?>
<?php else:?>
暂无
<?php endif;?>
