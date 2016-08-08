<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午3:32
 */

namespace common\modules\user;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $enableGeneratingPassword = true;

    /** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    /** @var bool Whether to enable registration. */
    public $enableRegistration = true;

    /** @var bool Whether user has to confirm his account. */
    public $enableConfirmation = true;

    /** @var bool Whether to allow logging in without confirmation. */
    public $enableUnconfirmedLogin = false;

    /** @var bool Whether to enable password recovery. */
    public $enablePasswordRecovery = true;

    /** @var bool Whether user can remove his account */
    public $enableAccountDelete = false;

    /**  @var string rbac默认管理员permission名 */
    public $adminPermission = 'admin';

    public $admins = [];

    public $defaultPassword = '111111';

    public $urlPrefix = 'user';

    public $urlRules = [
        '<id:\d+>' => 'default/index',
        '<action:(login|logout)>' => 'security/<action>',
        '<action:(signup)>' => 'registration/<action>',
        '<action:(up|article-list|create-article|update-article|notice|favourite)>' => 'default/<action>',
    ];

    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['user'])) {
            Yii::$app->i18n->translations['user'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/modules/user/messages'
            ];
        }
    }

    public function bootstrap($app)
    {
        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'common\modules\user\models\User',
            'loginUrl' => ['/user/security/login'],
            'enableAutoLogin' => true,
            'on afterLogin' => function($event) {
                $event->identity->touch('login_at');
            }
        ]);

        if ($app->id == 'app-frontend') {
            $this->attachBehavior('frontend', 'common\modules\user\filters\FrontendFilter');
        } elseif ($app->id == 'app-backend') {
            $this->attachBehavior('backend', 'common\modules\user\filters\BackendFilter');
            Yii::$container->set('yii\web\User', [
                'idParam' => '__idBackend',
                'identityCookie' => ['name' => '_identityBackend', 'httpOnly' => true]
            ]);
            $app->urlManager->addRules([
                'user/<action:\S+>' => 'user/admin/<action>',
            ], false);
        }

        $configUrlRule = [
            'prefix' => $this->urlPrefix,
            'rules'  => $this->urlRules,
        ];

        if ($this->urlPrefix != 'user') {
            $configUrlRule['routePrefix'] = 'user';
        }

        $configUrlRule['class'] = 'yii\web\GroupUrlRule';
        $rule = Yii::createObject($configUrlRule);

        $app->urlManager->addRules([$rule], false);
    }
}