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
    echo '<form class="navbar-form navbar-left" role="search">
        <div class="form-group">
        <input type="text" class="form-control" placeholder="搜索">
        </div><button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button>
      </form>';
    $rightMenuItems = [];
//    $rightMenuItems[] = ['label' => '下载', 'url' => ['/download']];
    $rightMenuItems[] = ['label' => '反馈', 'url' => ['/suggest/create']];
    $rightMenuItems[] = ['label' => '投稿', 'url' => ['/article/create']];
    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup'], 'options'=>['class'=>'pull-right']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => ['/user/index'],
            'items' => [
                [
                    'label'=>'设置',
                    'url'=>['/usr/settings']
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
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>

        <p class="pull-right">京ICP备15065774号</p>
    </div>
    <div class="container">
        本网站所收集的部分公开资料来源于互联网，转载的目的在于传递更多信息及用于网络分享，并不代表本站赞同其观点和对其真实性负责，也不构成任何其他建议。本站部分作品是由网友自主投稿和发布、编辑整理上传，对此类作品本站仅提供交流平台，不为其版权负责。如果您发现网站上有侵犯您的知识产权的作品，请与我们取得联系，我们会及时修改或删除。
        本网站所提供的信息，只供参考之用。本网站不保证信息的准确性、有效性、及时性和完整性。本网站及其雇员一概毋须以任何方式就任何信息传递或传送的失误、不准确或错误，对用户或任何其他人士负任何直接或间接责任。在法律允许的范围内，本网站在此声明，不承担用户或任何人士就使用或未能使用本网站所提供的信息或任何链接所引致的任何直接、间接、附带、从属、特殊、惩罚性或惩戒性的损害赔偿。
        电子邮件：332672087#qq.com（发邮件时，请将“#”替换为“@”）
        联系电话：18045665692
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
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
