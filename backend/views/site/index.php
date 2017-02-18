<?php
use rbac\components\MenuHelper;
use rbac\models\Menu;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \yii\web\Controller */

backend\assets\AppAsset::register($this);
\backend\assets\HuiAsset::register($this);
$leftMenuItems = [];
if (!isset($this->params['menuGroup'])) {
    $context = $this->context;
    $route = '/' . $context->uniqueId . '/' . ($context->action->id ?: $context->defaultAction);
    $leftMenu = Menu::findOne(['route' => $route]);
    if ($leftMenu == null) {
        $route = '/' . $context->uniqueId . '/' . $context->defaultAction;
        $leftMenu = Menu::findOne(['route' => $route]);
    }
    if ($leftMenu != null) {
        $groupMenu = MenuHelper::getRootMenu($leftMenu);
        $this->params['menuGroup'] = $groupMenu->name;
        $leftMenuItems = MenuHelper::getAssignedMenu(\Yii::$app->user->id, $groupMenu['id']);
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition <?= Yii::$app->config->get('BACKEND_SKIN', 'skin-green') ?> sidebar-mini fixed">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header.php'
    ) ?>

    <?= $this->render(
        'left.php',
        [
            'leftMenuItems' => $leftMenuItems
        ]
    )
    ?>

    <?= $this->render(
        'content.php',
        ['content' => $content]
    ) ?>

</div>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>