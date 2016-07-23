<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\gii\crud;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Generates admin CRUD
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    /**
     * @var string controller context model classes.
     */
    public $contextClass;
    /**
     * @inheritdoc
     */
    public $baseControllerClass = 'yii2tech\admin\CrudController';
    /**
     * @inheritdoc
     */
    public $messageCategory = 'admin';


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Admin CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['contextClass', 'safe'],
            ['contextClass', 'match', 'pattern' => '/^[\w\\\\]+(\s*,\s*[\w\\\\]+)*$/', 'message' => 'Only word characters and backslashes are allowed.'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'contextClass' => 'Context Class',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'contextClass' => 'This is the ActiveRecord class, which serves as context for the contoller.
                You should provide a fully qualified class name, e.g., <code>app\models\User</code>.
                You may specify several classes separated by comma.',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['contextClass']);
    }

    /**
     * Returns the root path to the original parent default code template files.
     * @return string the root path to the original parent default code template files.
     */
    public function parentDefaultTemplate()
    {
        return Yii::getAlias('@yii/gii/generators/crud/default');
    }

    /**
     * @inheritdoc
     */
    public function getNameAttribute()
    {
        foreach ($this->getColumnNames() as $name) {
            if (!strcasecmp($name, 'username') || !strcasecmp($name, 'email')) {
                return $name;
            }
        }
        return parent::getNameAttribute();
    }

    /**
     * @return array contexts in format: contextName => contextClassName.
     */
    public function getContexts()
    {
        if (empty($this->contextClass)) {
            return [];
        }
        $result = [];
        $classes = preg_split('/,/', $this->contextClass, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($classes as $class) {
            $result[Inflector::camel2id(StringHelper::basename($class))] = $class;
        }
        return $result;
    }
}