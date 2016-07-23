<?php
/**
 * This is the template for generating a index view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

echo "<?php\n";
?>

use yii\bootstrap\Html;

/* @var $this yii\web\View */

$this->title = <?= $generator->generateString('{appName} Administration', ['appName' => Yii::$app->name]) ?>;

$blocks = [
    [
        'title' => 'Administrator Accounts',
        'description' => 'Setup administrator accounts',
        'label' => 'Administrators',
        'icon' => 'user',
        'url' => ['/administrator/index'],
    ],
    [
        'title' => 'Users Accounts',
        'description' => 'Manage users accounts',
        'label' => 'Users',
        'icon' => 'user',
        'url' => ['/user/index'],
    ],
];
?>
<div class="site-index">
    <div class="body-content">

<?= "<?php " ?> foreach ($blocks as $number => $block): ?>
    <?= "<?php " ?> if ($number % 3 == 0): ?>
        <?= "<?php " ?> if ($number != 0): ?>
    </div>
        <?= "<?php " ?> endif; ?>
    <div class="row">
    <?= "<?php " ?> endif; ?>
        <div class="col-lg-4">
            <h3><?= "<?= " ?> $block['title'] ?></h3>
            <p><?= "<?= " ?> $block['description'] ?></p>
            <p><?= "<?= " ?> Html::a(Html::icon($block['icon']) . ' ' . $block['label'], $block['url'], ['class' => 'btn btn-default']) ?></p>
        </div>
<?= "<?php " ?> endforeach; ?>

    </div>
</div>
