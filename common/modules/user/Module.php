<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午3:32
 */

namespace common\modules\user;

use common\behaviors\UserBehaviorBehavior;
use common\modules\user\clients\QqAuth;
use common\modules\user\clients\WeiboAuth;
use common\modules\user\clients\WeixinAuth;
use Yii;
use yii\authclient\clients\GitHub;
use yii\base\BootstrapInterface;
use yii\web\User;

class Module extends \common\modules\Module implements BootstrapInterface
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

    public $urlRules = [];

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
        if ($app->id == 'backend') {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'common\modules\user\models\User',
                'loginUrl' => ['/user/default/login'],
                'enableAutoLogin' => true,
                'on afterLogin' => function($event) {
                    $event->identity->touch('login_at');
                },
                'idParam' => '__idBackend',
                'identityCookie' => ['name' => '_identityBackend', 'httpOnly' => true]
            ]);
        } else {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'common\modules\user\models\User',
                'loginUrl' => ['/user/security/login'],
                'enableAutoLogin' => true,
                'on afterLogin' => function($event) {
                    $event->identity->touch('login_at');
                },
                'as userBehavior' => [
                    'class' => UserBehaviorBehavior::className(),
                    'eventName' => User::EVENT_AFTER_LOGIN,
                    'name' => 'login',
                    'rule' => [
                        'cycle' => 24,
                        'max' => 1,
                        'counter' => 10,
                    ],
                    'content' => '{user.username}在{extra.time}登录了系统',
                    'data' => [
                        'extra' => [
                            'time' => date('Y-m-d H:i:s')
                        ]
                    ]
                ]
            ]);
            $config = $this->params;
            $params = [
                'qq' => [
                    'class' => QqAuth::className(),
                    'clientId' => $config['qq_client_id'],
                    'clientSecret' => $config['qq_client_secret']
                ],
                'github' => [
                    'class' => GitHub::className(),
                    'clientId' => $config['github_client_id'],
                    'clientSecret' => $config['github_client_secret']
                ],
                'weibo' => [
                    'class' => WeiboAuth::className(),
                    'clientId' => $config['weibo_client_id'],
                    'clientSecret' => $config['weibo_client_secret']
                ],
                'weixin' => [
                    'class' => WeixinAuth::className(),
                    'clientId' => $config['weixin_client_id'],
                    'clientSecret' => $config['weixin_client_secret']
                ],
            ];
            $openClients = $config['open_client'];
            $openParams = [];
            if (!empty($openClients)) {
                foreach ($openClients as $client) {
                    $client = strtolower($client);
                    $openParams[$client] = $params[$client];
                }
            }
            $app->set('authClientCollection', [
                'class' => 'yii\authclient\Collection',
                'clients' => $openParams
            ]);
            $this->urlRules = [
                '<id:\d+>' => 'default/index',
                '<action:(login|logout)>' => 'security/<action>',
                '<action:(signup)>' => 'registration/<action>',
                '<action:(up|article-list|create-article|update-article|notice|favourite)>' => 'default/<action>',
            ];
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