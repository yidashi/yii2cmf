<?php
use yii\widgets\Menu;
$user = Yii::$app->user->identity;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <img src="<?= $user->getAvatar(24)?>" class="img-rounded"
                 alt="<?= $user->username ?>" width="24" height="24"/>
            <?= $user->username?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget(['options' => ['class' => 'nav nav-pills nav-stacked'],'items' => [
            ['label' => '个人信息','url' => ['/user/profile']],
            ['label' => '头像设置','url' => ['/user/avatar']],
            ['label' => '我的发布','url' => ['/user/article-list']],
            ['label' => '我的通知','url' => ['/user/notice']],
            ['label' => '我赞过的','url' => ['/user/up']],
            ['label' => '我收藏的','url' => ['/user/favourite']],
        ]]) ?>
    </div>
</div>