<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\gii\mainframe;

use Yii;
use yii\base\Model;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\web\Controller;

/**
 * Generates admin main frame: main controller, layouts, views etc.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string main controller class name
     */
    public $controllerClass = 'app\controllers\admin\SiteController';
    /**
     * @var string base controller class
     */
    public $baseControllerClass = 'yii\web\Controller';
    /**
     * @var string view path
     */
    public $viewPath = '@app/views/admin';
    /**
     * @var string login form model class
     */
    public $loginModelClass = '\app\models\admin\LoginForm';
    /**
     * @inheritdoc
     */
    public $messageCategory = 'admin';


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Admin MainFrame Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates layouts and common views for administration area. Created layouts supports correct
            rendering of the admin CRUD views';
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        // Controller :
        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];

        // Layouts :
        $viewPath = $this->getViewPath() . '/layouts';
        $templatePath = $this->getTemplatePath() . '/layouts';
        foreach (scandir($templatePath) as $file) {
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("layouts/$file"));
            }
        }

        // Controller views :
        $viewPath = $this->getViewPath() . '/' . $this->getControllerID();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['loginModelClass', 'controllerClass', 'viewPath'], 'filter', 'filter' => 'trim'],
            [['loginModelClass', 'controllerClass', 'viewPath'], 'required'],
            [['loginModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['loginModelClass'], 'validateClass', 'params' => ['extends' => Model::className()]],
            [['baseControllerClass'], 'validateClass', 'params' => ['extends' => Controller::className()]],
            [['controllerClass'], 'match', 'pattern' => '/Controller$/', 'message' => 'Controller class name must be suffixed with "Controller".'],
            [['controllerClass'], 'match', 'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Controller$/', 'message' => 'Controller class name must start with an uppercase letter.'],
            [['controllerClass'], 'validateNewClass'],
            [['viewPath'], 'match', 'pattern' => '/^@?\w+[\\-\\/\w]*$/', 'message' => 'Only word characters, dashes, slashes and @ are allowed.'],
            [['viewPath'], 'validatePath'],
            [['enableI18N'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'loginModelClass' => 'Login Model Class',
            'controllerClass' => 'Controller Class',
            'viewPath' => 'View Path',
            'baseControllerClass' => 'Base Controller Class',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['controller.php'];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'loginModelClass' => 'This is the model class for admin panel login form. You should provide a fully qualified class name, e.g., <code>app\models\admin\LoginForm</code>.',
            'controllerClass' => 'This is the name of the controller class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>app\controllers\admin\SiteController</code>),
                and class name should be in CamelCase with an uppercase first letter. Make sure the class
                is using the same namespace as specified by your application\'s controllerNamespace property.',
            'viewPath' => 'This is the root view path to keep the generated view files. You may provide either a directory or a path alias, e.g., <code>@app/views/admin</code>.',
            'baseControllerClass' => 'This is the class that the new CRUD controller class will extend from.
                You should provide a fully qualified class name, e.g., <code>yii\web\Controller</code>.',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['baseControllerClass']);
    }

    /**
     * Validates file path to make sure it is a valid path or path alias and exists.
     * @param string $attribute the attribute currently being validated.
     * @param array $params the additional name-value pairs given in the rule.
     */
    public function validatePath($attribute, $params)
    {
        $path = Yii::getAlias($this->{$attribute}, false);
        if ($path === false || !is_dir($path)) {
            $this->addError($attribute, 'Path does not exist.');
        }
    }

    /**
     * @return string the controller ID (without the module ID prefix)
     */
    public function getControllerID()
    {
        $pos = strrpos($this->controllerClass, '\\');
        $class = substr(substr($this->controllerClass, $pos + 1), 0, -10);

        return Inflector::camel2id($class);
    }

    /**
     * @return string the controller view path
     */
    public function getViewPath()
    {
        return Yii::getAlias($this->viewPath);
    }
}