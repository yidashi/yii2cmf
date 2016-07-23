<?php
/**
 * This is the template for generating the error view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="alert alert-danger">
    <?= "<?= " ?> nl2br(Html::encode($message)) ?>
</div>

<p>
    <?= $generator->generateString('The above error occurred while the Web server was processing your request.') ?>
</p>