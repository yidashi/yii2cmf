<?php
/**
 * This is the template for generating the overall layout view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

echo "<?php\n";
?>

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\admin\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii2tech\admin\widgets\Alert;

AppAsset::register($this);
?>
<?= "<?php " ?> $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= "<?= " ?> Yii::$app->language ?>">
<head>
    <meta charset="<?= "<?= " ?> Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= "<?= " ?> Html::csrfMetaTags() ?>
    <title><?= "<?= " ?> Html::encode($this->title) ?></title>
    <?= "<?php " ?> $this->head() ?>
</head>
<body>
<?= "<?php " ?> $this->beginBody() ?>

<div class="wrap">
    <?= "<?= " ?> $this->render('/layouts/mainMenu'); ?>

    <div class="container-fluid">
        <?= "<?php " ?> if (!Yii::$app->user->isGuest) : ?>
        <?= "<?= " ?> Breadcrumbs::widget([
                'homeLink' => [
                    'label' => Yii::t('admin', 'Administration'),
                    'url' => Yii::$app->homeUrl,
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        <?= "<?= " ?> Alert::widget() ?>
        <?= "<?php " ?> endif; ?>
        <?= "<?= " ?> $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= "<?= " ?> Yii::$app->name ?> <?= "<?= " ?> date('Y') ?></p>
    </div>
</footer>

<?= "<?php " ?> $this->endBody() ?>
</body>
</html>
<?= "<?php " ?> $this->endPage() ?>
