<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午3:32
 */

namespace common\modules\user;

use Yii;

class Module extends \yii\base\Module
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
}