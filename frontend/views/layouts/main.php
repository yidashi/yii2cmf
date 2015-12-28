<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->registerMetaTag(['property' => 'keywords', 'content' => '信热文精选,微信,文章,好文章,微信文摘,美文,微信文章大全,微信公众平台,微信文章,微信文章怎么写,微信文章哪里找,微信文章编辑,微信公众平台,订阅号,微信营销,二维码,伤感文章,情感文章,微信段子']);?>
    <?php $this->registerMetaTag(['property' => 'description', 'content' => '微信热文精选微信文章精选是收录微信文章、微信段子的微信文摘网站。健康,正能量的微信文章，令人阅读受益，更能即刻分享到朋友圈！微信好文章能助力微信分享、微信营销、微信公众平台使用。网站内容涉及,微信文摘,微信文章大全,微信文章集锦,微信分享,微信公众号,服务号,订阅号,微博,心灵鸡汤,励志,情感,男女,文化,职场,人生,家庭,美食,幽默,开心,星座,生肖,人际,社会,新闻,热议,旅游等']);?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/']],
    ];
    foreach(\common\models\Category::find()->all() as $nav){
        $menuItems[] = ['label' => $nav['title'], 'url' => ['/article','cid'=>$nav['id']]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    $rightMenuItems = [];
    $rightMenuItems[] = ['label' => '反馈', 'url' => ['/suggest/create']];
    $rightMenuItems[] = ['label' => '投稿', 'url' => ['/my/create-article']];
    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup'], 'options'=>['class'=>'pull-right']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                [
                    'label'=>'我的主页',
                    'url'=>['/my/settings']
                ],
                [
                    'label' => '我的投稿',
                    'url' => ['/my/article-list']
                ],
                [
                    'label' => '退出',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?php if(stripos(Yii::$app->request->headers->get('User-Agent'), 'MicroMessenger') === false): ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6"><a href="<?= \yii\helpers\Url::to(['/site/about'])?>">免责声明</a></div>
            <div class="col-lg-6"><a href="<?= \yii\helpers\Url::to(['/site/about'])?>">关于我们</a></div>
        </div>
    </div>
    <hr/>
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>
        <p class="pull-right"><?= Yii::$app->params['icp']?></p>
    </div>
</footer>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<a class="back-to-top btn btn-default" style="display: none;"><span class="fa fa-arrow-up"></span></a>
<?php if(YII_ENV_PROD): ?>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=53223522" charset="UTF-8"></script>
<?php endif; ?>
<script>
    (function(){
        var bp = document.createElement('script');
        bp.src = '//push.zhanzhang.baidu.com/push.js';
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
