<!-- HEADER SECTION START-->
<header id="header" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand"><?= Yii::$app->config->get('SITE_NAME') ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav"><li class="dropdown active"><a href="/index.php">首页</a></li>
                <li class="dropdown"><a href="http://www.51siyuan.cn/" target="_blank">演示</a></li>
                <li class="dropdown"><a href="<?= url(['/suggest']) ?>">留言</a></li>
                <li class="dropdown has-children"><a href="#">支持</a>
                    <ul class='dropdown-menu'>
                        <li class="dropdown"><a href="#">文档</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--                        <li class="dropdown"><a href="/index.php?r=plugin%2Findex"><i class="fa fa-flask"></i>&nbsp;插件</a></li>-->
                <!--                        <li class="dropdown"><a href="/index.php?r=theme%2Findex"><i class="fa fa-star-half-o"></i>&nbsp;主题</a></li>-->
                <?php if(Yii::$app->user->isGuest): ?>
                    <li class="dropdown">
                        <a href="#"><i class="fa fa-user"></i>&nbsp;账号</a>
                        <ul class='dropdown-menu'>
                            <li class="dropdown"><a href="<?= url(['/site/login']) ?>">登录</a></li>
                            <li class="dropdown"><a href="<?= url(['/site/signup']) ?>">注册</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#"><i class="fa fa-user"></i> <?= Yii::$app->user->identity->username ?></a>
                        <ul class='dropdown-menu'>
                            <li class="dropdown"><a href="<?= url(['/site/logout']) ?>" data-method="post">退出</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</header>
<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 上午12:06
 */
/* @var $this \yii\web\View */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\helpers\Html;

?>

<?php
NavBar::begin([
    'brandLabel' => Yii::$app->config->get('SITE_NAME'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'tag' => 'header',
        'class' => 'navbar-inverse navbar-fixed-top'
    ],
]);
$menuItems = [];
$menuItems[] = ['label' => '首页', 'url' => Yii::$app->homeUrl, 'active' => \Yii::$app->controller->getRoute() == 'site/index'];
$menuItems[] = ['label' => '演示', 'url' => 'http://www.51siyuan.cn/', 'linkOptions' => ['target' => '_blank']];
$menuItems[] = ['label' => '留言', 'url' => ['/suggest'], 'active' => \Yii::$app->controller->getRoute() == 'suggest/index'];
$this->params['leftMenuItems'] = $menuItems;
// 挂个钩子,方便扩展导航
$this->trigger('leftNav');
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $this->params['leftMenuItems'],
    'encodeLabels' => false
]);

$rightMenuItems = [];
$noticeNums = Yii::$app->notify->getNoReadNums();
if ($noticeNums > 0) {
    $rightMenuItems[] = [
        'label' => '<i class="fa fa-bell"></i> <span class="badge">' . $noticeNums . '</span>',
        'items' => [
            [
                'label' => $noticeNums . '条新消息',
                'url' => ['/notice']
            ]
        ]
    ];
}
$rightMenuItems[] = ['label' => '插件', 'url' => ['/article/index', 'cate' => 'plugins']];
if (Yii::$app->user->isGuest) {
    $rightMenuItems[] = ['label' => Yii::t('common', 'Signup'), 'url' => ['/site/signup']];
    $rightMenuItems[] = ['label' => Yii::t('common', 'Login'), 'url' => ['/site/login']];
} else {
    $rightMenuItems[] = [
        'label' => Html::img(Yii::$app->user->identity->profile->avatar, ['width' => 32, 'height' => 32]),
        'linkOptions' => [
            'class' => 'avatar'
        ],
        'items' => [
            [
                'label' => Html::icon('sign-out') . ' 退出',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ]
        ]
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $rightMenuItems,
    'encodeLabels' => false
]);
NavBar::end();
?>
