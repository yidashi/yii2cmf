<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 上午12:06
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\helpers\Html;

?>

<?php
NavBar::begin([
    'options' => [
        'class' => 'navbar-inverse navbar-static-top',
    ],
]);
$menuItems = [];
$menuItems[] = ['label' => '首页', 'url' => Yii::$app->homeUrl];
// 暂只支持两级,多了也没意义
foreach (\common\models\Category::tree(\common\models\Category::find()->where(['is_nav' => 1])->orderBy('sort asc')->asArray()->all()) as $nav) {
    $firstItem = ['label' => $nav['title'], 'url' => ['/article/index', 'cate' => $nav['name']]];
    if (isset($nav['_child'])) {
        $secondItems = [];
        foreach($nav['_child'] as $second) {
            $secondItems[] = ['label' => $second['title'], 'url' => ['/article/index', 'cate' => $second['name']]];
        }
        $firstItem['items'] = $secondItems;
    }
    $menuItems[] = $firstItem;
}
$menuItems[] = ['label' => '获取源码', 'url' => ['/page/index', 'name' => 'code']];
$menuItems[] = ['label' => '留言', 'url' => ['/suggest/index']];
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
$searchUrl = url(['/search']);
echo <<<SEARCH
<form class="navbar-form visible-lg-inline-block" action="{$searchUrl}" method="get">
    <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="搜索">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="fa fa-search"></span>
            </button>
        </span>
    </div>
</form>
SEARCH;

$rightMenuItems = [];
$rightMenuItems[] = ['label' => '投稿', 'url' => ['/my/create-article']];
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
} else {
    $rightMenuItems[] = [
        'label' => '<i class="fa fa-bell"></i>',
        'url' => ['/notice']
    ];
}
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
                'label' => Html::icon('user') . ' 个人信息',
                'url' => ['/user', 'id' => Yii::$app->user->id],
            ],
            [
                'label' => Html::icon('book') . ' 我的投稿',
                'url' => ['/my/article-list'],
            ],
            [
                'label' => Html::icon('thumbs-up') . ' 我顶过的',
                'url' => ['/my/up'],
            ],
            [
                'label' => Html::icon('star') . ' 我收藏的',
                'url' => ['/my/favourite'],
            ],
            [
                'label' => Html::icon('sign-out') . ' 退出',
                'url' => ['/site/logout'],
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
