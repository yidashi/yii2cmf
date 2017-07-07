<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午4:02
 */

namespace common\modules\user\frontend\controllers;

use common\modules\user\models\Auth;
use common\modules\user\models\LoginForm;
use common\modules\user\models\PasswordResetRequestForm;
use common\modules\user\models\ResetPasswordForm;
use common\modules\user\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class SecurityController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    public function actions()
    {

        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => \Yii::$app->user->isGuest
                    ? [$this, 'authenticate']
                    : [$this, 'connect'],
                'redirectView' => __DIR__ . '/redirect.php'
            ],
        ];
    }

    public function authenticate(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');

        /** @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $id,
        ])->one();

        if ($auth) { // login
            /** @var User $user */
            $user = $auth->user;
            Yii::$app->user->login($user);
        } else { // signup
            if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                ]);
            } else {
                $password = Yii::$app->security->generateRandomString(6);
                $user = new User([
                    'scenario' => 'create',
                    'username' => User::findByUsername($nickname) ? $nickname . '_' . mt_rand(1000, 9999) : $nickname,
                    'email' => $email,
                    'password' => $password,
                ]);
                $user->generateAuthKey();
                $user->generatePasswordResetToken();

                $transaction = User::getDb()->beginTransaction();

                if ($user->save()) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    if ($auth->save()) {
                        $transaction->commit();
                        Yii::$app->user->login($user);
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save {client} account: {errors}', [
                                'client' => $client->getTitle(),
                                'errors' => json_encode($auth->getErrors()),
                            ]),
                        ]);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to save user: {errors}', [
                            'client' => $client->getTitle(),
                            'errors' => json_encode($user->getErrors()),
                        ]),
                    ]);
                }
            }
        }
    }

    public function connect(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        $id = ArrayHelper::getValue($attributes, 'id');

        /** @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $id,
        ])->one();

        if (!$auth) { // add auth provider
            $auth = new Auth([
                'user_id' => Yii::$app->user->id,
                'source' => $client->getId(),
                'source_id' => (string)$attributes['id'],
            ]);
            if ($auth->save()) {
                /** @var User $user */
                Yii::$app->getSession()->setFlash('success', [
                    Yii::t('app', 'Linked {client} account.', [
                        'client' => $client->getTitle()
                    ]),
                ]);
            } else {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Unable to link {client} account: {errors}', [
                        'client' => $client->getTitle(),
                        'errors' => json_encode($auth->getErrors()),
                    ]),
                ]);
            }
        } else { // there's existing auth
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app',
                    'Unable to link {client} account. There is another user using it.',
                    ['client' => $client->getTitle()]),
            ]);
        }
        $this->action->successUrl = Url::to(['/user/settings/auth']);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return ['message' => '登录成功'];
            }
            return $this->goBack();
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('login', [
                    'model' => $model,
                    'module' => $this->module
                ]);
            }

            return $this->render('login', [
                'model' => $model,
                'module' => $this->module
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '请登录邮箱重置密码');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '很抱歉,发生错误了!');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '新密码设置成功！');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}