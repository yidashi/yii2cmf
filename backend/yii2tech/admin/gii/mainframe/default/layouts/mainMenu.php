<?php
/**
 * This is the template for generating a main menu view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

echo "<?php\n";
?>
/* @var $this \yii\web\View */

use yii2tech\admin\widgets\Nav;
use yii\bootstrap\NavBar;

$webUser = Yii::$app->user;

NavBar::begin([
    'id' => 'header-nav-bar',
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
    ],
]);

if (!$webUser->isGuest) {
    echo Nav::widget([
        'id' => 'header-main-menu',
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            [
                'label' => <?= $generator->generateString('Users') ?>,
                'icon' => 'user',
                'items' => [
                    [
                        'label' => <?= $generator->generateString('Administrators') ?>,
                        'icon' => 'user',
                        'url' => ['admin/index'],
                    ],
                    [
                        'label' => <?= $generator->generateString('Users') ?>,
                        'icon' => 'user',
                        'url' => ['user/index'],
                    ],
                ],
            ],
        ],
    ]);
}

$menuItems = [
    ['label' => Yii::t('yii', 'Home'), 'url' => Yii::$app->request->getBaseUrl() . '/', 'icon' => 'home'],
];
if ($webUser->isGuest) {
    $menuItems[] = ['label' => <?= $generator->generateString('Login') ?>, 'url' => ['/site/login'], 'icon' => 'log-in'];
} else {
    $menuItems[] = [
        'label' => $webUser->identity->username,
        'items' => [
            [
                'label' => <?= $generator->generateString('Profile') ?>,
                'url' => ['/admin/update', 'id' => $webUser->id],
                'icon' => 'pencil'
            ],
            [
                'label' => <?= $generator->generateString('Logout') ?>,
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
                'icon' => 'log-out',
            ],
        ],

    ];
}
echo Nav::widget([
    'id' => 'header-common-menu',
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();