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
            ['label' => '基础设置','url' => ['/user/settings/basic']],
            ['label' => '个人资料','url' => ['/user/settings/profile']],
            ['label' => '头像设置','url' => ['/user/settings/avatar']],
            ['label' => '授权管理','url' => ['/user/settings/auth']],
        ]]) ?>
    </div>
</div>