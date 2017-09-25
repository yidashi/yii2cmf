<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 上午12:06
 */
/* @var $this \yii\web\View */
use common\models\Nav as NavModel;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

?>
<?php \yii\widgets\Pjax::begin([
    'id' => 'header-container',
    'linkSelector' => false,
    'formSelector' => false
]) ?>
<?php
NavBar::begin([
    'brandLabel' => Yii::$app->config->get('site_logo') ? Html::img(Yii::$app->config->get('site_logo'), ['width' => 62, 'height' => 30]) : Yii::$app->config->get('site_name'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse'
    ],
]);
$menuItems = NavModel::getItems('header');
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
$searchUrl = url(['/search/index']);
$q = Yii::$app->request->get('q', '全站搜索');
?>
<?php $form = \yii\widgets\ActiveForm::begin(['action' => $searchUrl, 'method' => 'get', 'options' => ['class' => 'navbar-form visible-lg-inline-block']]) ?>
    <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="{$q}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="fa fa-search"></span>
            </button>
        </span>
    </div>
<?php \yii\widgets\ActiveForm::end() ?>
<?php
$rightMenuItems = [];
$rightMenuItems[] = ['label' => '投稿', 'url' => ['/user/default/create-article']];
$noticeNum = Yii::$app->notify->getNoReadNum();
if ($noticeNum > 0) {
    $rightMenuItems[] = [
        'label' => '<i class="fa fa-bell"></i> <span class="badge">' . $noticeNum . '</span>',
        'items' => [
            [
                'label' => $noticeNum . '条新消息',
                'url' => ['/user/default/notice']
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
                'url' => ['/user/default/article-list'],
            ],
            [
                'label' => Html::icon('star') . ' 我的收藏',
                'url' => ['/user/default/favourite'],
            ],
            [
                'label' => Html::icon('sign-out') . ' 退出',
                'url' => ['/user/security/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ]
        ]
    ];
}

$this->params['rightMenuItems'] = $rightMenuItems;
$this->trigger('beforeRenderRightMenu');
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $this->params['rightMenuItems'],
    'encodeLabels' => false
]);
NavBar::end();
?>
<?php \yii\widgets\Pjax::end() ?>