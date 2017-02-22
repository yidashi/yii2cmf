<?php
use rbac\components\MenuHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$logCount = \backend\models\SystemLog::find()->count();
$menuGroups = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, function ($menu){
    return [
        'id' => $menu['id'],
        'name' => $menu['name'],
    ];
});
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->config->get('SITE_NAME') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><?= Html::a('<i class="fa fa-home"></i>', Yii::$app->config->get('SITE_URL'), ['target' => '_blank', 'data-not-iframe' => '1']) ?></li>
                <li id="log-dropdown" class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                        <?php if($logCount > 0) : ?>
                            <span class="label label-danger">
                                <?= $logCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            <?= sprintf('你有%d条日志', $logCount) ?>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                    <li>
                                        <a href="<?= Url::to(['/log/view', 'id'=>$logEntry->id]) ?>" target="_blank" title="错误日志">
                                            <i class="fa fa-warning <?= $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                            <?= $logEntry->category ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="footer">
                            <?= Html::a('查看全部', ['/log/index'], ['target' => '_blank', 'title' => '错误日志']) ?>
                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#"
                                                       class="dropdown-toggle" data-toggle="dropdown"> <img
                            src="<?= Yii::$app->user->identity->getAvatar(96) ;?>" class="user-image"
                            alt="User Image" /> <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header"><img
                                src="<?=  Yii::$app->user->identity->getAvatar(96) ;?>" class="img-circle"
                                alt="User Image" />

                            <p>
                                <?= Yii::$app->user->identity->username ?> - <?= current(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))->description ?>
                                <small>注册时间:<?= Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at) ?></small>
                            </p></li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('修改密码', ['/user/admin/reset-password', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default btn-flat', 'target' => '_blank', 'title' => '修改密码'])?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('登出', ['/user/admin/logout' ], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat'])?>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><?= Html::a('<i class="fa  fa-sign-out"></i>', ['/user/admin/logout'], ['data-method' => 'post']) ?></li>
            </ul>
        </div>
        <div class="navbar-header">
            <button class="btn btn-default  btn-sm navbar-toggle collapsed"
                    type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="caret"></span>
            </button>
        </div>

        <div class="navbar-collapse collapse" role="navigation">
            <ul class="navbar-nav nav">
                <?php foreach ($menuGroups as $key => $menuGroup) : ?>
                    <li <?php if ($key == 0) {echo 'class="active"';} ?>><a href="#menu-group-<?= $menuGroup['id'] ?> " data-toggle="tab"><?= $menuGroup['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="tab-content">

        <?php foreach ($menuGroups as $key => $menuGroup): ?>
        <div class="tab-pane <?php if ($key == 0) {echo 'active';} ?>" id="menu-group-<?= $menuGroup['id'] ?>">
            <?= \backend\widgets\Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menuGroup['id'])
            ]) ?>
        </div>
        <?php endforeach; ?>

        </div>
    </section>
</aside>

