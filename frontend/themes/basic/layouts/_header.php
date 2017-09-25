<?php
/**
 * @var \yii\web\View $this
 */
use yii\helpers\Html;
use yii\bootstrap\Nav;
?>
<header class="container mb15">
    <?php \yii\widgets\Pjax::begin([
        'id' => 'header-container',
        'linkSelector' => false,
        'formSelector' => false,
        'options' => ['class' => 'm-sitenav clearfix']
    ]) ?>
        <div class="pull-left">
            您好，欢迎来到 <?= Yii::$app->config->get('site_name') ?>
        </div>
            <?php
            $rightMenuItems = [];
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
            ?>
    <?php \yii\widgets\Pjax::end() ?>
    <div class="m-header">
        <div class="wrap clearfix">
            <div class="m-logo"><a href="<?= \yii\helpers\Url::home() ?>" title="<?= Yii::$app->config->get('site_name') ?>" style="background:url(<?= Yii::$app->config->get('site_logo') ?>) no-repeat;background-size: contain"><?= Yii::$app->config->get('site_name') ?><span></span></a></div>
            <div class="u-search">
                <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['/search/index'], 'method' => 'get', 'options' => ['class' => 'form']]) ?>
                    <input type="text" id="dk-text" class="text" autocomplete="off" placeholder="<?= Yii::$app->request->get('q', '全站搜索'); ?>" name="q">
                    <a title="搜索" class="icn-search2 fa fa-search" data-method="get"></a>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="list" style="visibility:hidden;"></div>
            </div>
        </div>
    </div>
    <nav class="m-nav clearfix">
        <?php
        $navItems = \common\models\Nav::getItems('header');
        \yii\widgets\Spaceless::begin();
        echo \yii\widgets\Menu::widget([
            'items' => $navItems,
            'options' => ['class' => 'f-cb'],
            'activeCssClass' => 'crt'
        ]);
        \yii\widgets\Spaceless::end();
        ?>
    </nav>

</header>