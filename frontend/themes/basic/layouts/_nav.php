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
use common\models\Nav as NavModel;

?>

<?php
NavBar::begin([
    'brandLabel' => Yii::$app->config->get('SITE_LOGO') ? Html::img(Yii::$app->config->get('SITE_LOGO'), ['width' => 48, 'height' => 48]) : Yii::$app->config->get('SITE_NAME'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top'
    ],
]);
$menuItems = NavModel::getItems('header');
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
$searchUrl = url(['/search']);
$q = Yii::$app->request->get('q', '全站搜索');
echo <<<SEARCH
<form class="navbar-form visible-lg-inline-block" action="{$searchUrl}" method="get">
    <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="{$q}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="fa fa-search"></span>
            </button>
        </span>
    </div>
</form>
SEARCH;

$rightMenuItems = [];
$rightMenuItems[] = ['label' => '投稿', 'url' => ['/user/default/create-article']];
$noticeNums = Yii::$app->notify->getNoReadNums();
if ($noticeNums > 0) {
    $rightMenuItems[] = [
        'label' => '<i class="fa fa-bell"></i> <span class="badge">' . $noticeNums . '</span>',
        'items' => [
            [
                'label' => $noticeNums . '条新消息',
                'url' => ['/user/notice']
            ]
        ]
    ];
} else {
    $rightMenuItems[] = [
        'label' => '<i class="fa fa-bell"></i>',
        'url' => ['/user/default/notice']
    ];
}
if (Yii::$app->user->isGuest) {
    $rightMenuItems[] = ['label' => Yii::t('common', 'Signup'), 'url' => ['/user/registration/signup']];
    $rightMenuItems[] = ['label' => Yii::t('common', 'Login'), 'url' => ['/user/security/login']];
} else {
    $rightMenuItems[] = [
        'label' => Html::img(Yii::$app->user->identity->getAvatar(32), ['width' => 32, 'height' => 32]),
        'linkOptions' => [
            'class' => 'avatar'
        ],
        'items' => [
            [
                'label' => Html::icon('user') . ' 个人主页',
                'url' => ['/user/default/index', 'id' => Yii::$app->user->id],
            ],
            [
                'label' => Html::icon('cog') . ' 账户设置',
                'url' => ['/user/settings/profile'],
            ],
            [
                'label' => Html::icon('book') . ' 我的投稿',
                'url' => ['/user/article-list'],
            ],
            [
                'label' => Html::icon('thumbs-up') . ' 我赞过的',
                'url' => ['/user/up'],
            ],
            [
                'label' => Html::icon('star') . ' 我收藏的',
                'url' => ['/user/favourite'],
            ],
            [
                'label' => Html::icon('sign-out') . ' 退出',
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ]
        ]
    ];
}
$rightMenuItems[] = [
    'label'=>Yii::t('frontend', 'Language'),
    'items'=>array_map(function ($code) {
        return [
            'label' => Yii::$app->params['availableLocales'][$code],
            'url' => ['/site/set-locale', 'locale'=>$code],
            'active' => Yii::$app->language === $code
        ];
    }, array_keys(Yii::$app->params['availableLocales']))
];
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $rightMenuItems,
    'encodeLabels' => false
]);
NavBar::end();
?>
