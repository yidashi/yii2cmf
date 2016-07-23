<?php
/**
 * This is the template for generating a controller file.
 */

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$loginModelClass = StringHelper::basename($generator->loginModelClass);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use <?= ltrim($generator->loginModelClass, '\\') ?>;

/**
 * <?= $controllerClass ?> implements the common actions for admin panel.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Renders dashborad.
     * @return mixed response.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Renders login form.
     * @return mixed response.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new <?= $loginModelClass ?>();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out user.
     * @return mixed response.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
