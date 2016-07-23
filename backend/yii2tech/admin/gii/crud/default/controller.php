<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$contexts = $generator->getContexts();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->baseControllerClass, '\\') ?>;
<?php if (!empty($contexts)): ?>
use yii\helpers\ArrayHelper;
use yii2tech\admin\behaviors\ContextModelControlBehavior;
<?php endif ?>

/**
 * <?= $controllerClass ?> implements the CRUD actions for [[<?= $generator->modelClass ?>]] model.
 * @see <?= $generator->modelClass . "\n" ?>
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public $modelClass = '<?= $generator->modelClass ?>';
<?php if (!empty($generator->searchModelClass)): ?>
    /**
     * @inheritdoc
     */
    public $searchModelClass = '<?= $generator->searchModelClass ?>';
<?php endif ?>
<?php if (!empty($contexts)): ?>
    /**
     * Contexts configuration
     * @see ContextModelControlBehavior::contexts
     */
    public $contexts = [
<?php foreach ($contexts as $name => $class) : ?>
        // Specify actual contexts :
        '<?= $name ?>' => [
            'class' => '<?= $class ?>',
            'attribute' => '<?= lcfirst(StringHelper::basename($class)) ?>Id',
            'controller' => '<?= $name ?>',
            'required' => false,
        ],
    ];
<?php endforeach ?>


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'model' => [
                    'class' => ContextModelControlBehavior::className(),
                    'contexts' => $this->contexts
                ]
            ]
        );
    }
<?php endif ?>
}
