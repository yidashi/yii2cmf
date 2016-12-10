<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午5:56
 */

namespace common\modules\user\controllers;


use common\modules\user\models\LoginForm;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use common\modules\user\traits\AjaxValidationTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    use AjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['post'],
                    'confirm' => ['post'],
                    'block'   => ['post'],
                ],
            ],
        ];
    }
    public function actionLogin()
    {
        $this->layout = '@common/modules/user/views/admin/main-login.php';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('login', [
                    'model' => $model,
                ]);
            }

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new User(['scenario' => 'search']);
        $dataProvider = new ActiveDataProvider(['query' => $searchModel->search(['username'])]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));
            return $this->redirect(['update', 'id' => $user->id]);
        }

        return $this->render('create', [
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $user->scenario = 'update';

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            return $this->refresh();
        }

        return $this->render('_account', [
            'user' => $user,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 重置密码
     */
    public function actionResetPassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'resetPassword';
        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->user->logout();
            return $this->goHome();
        }
        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    public function actionUpdateProfile($id)
    {
        Url::remember('', 'actions-redirect');
        $user    = $this->findModel($id);
        $profile = $user->profile;

        if ($profile == null) {
            $profile = \Yii::createObject(Profile::className());
            $profile->link('user', $user);
        }

        if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Profile details have been updated'));
            return $this->refresh();
        }

        return $this->render('_profile', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }
    public function actionBlock($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return ['status' => 0, 'message' => \Yii::t('user', 'You can not block your own account')];
            }
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not block your own account'));
        } else {
            $user  = $this->findModel($id);
            if ($user->isAdmin) {
                throw new ForbiddenHttpException('不支持封禁管理员帐号');
            }
            if ($user->getIsBlocked()) {
                $user->unblock();
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = 'json';
                    return ['message' => \Yii::t('user', 'User has been unblocked')];
                }
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been unblocked'));
            } else {
                $user->block();
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = 'json';
                    return ['message' => \Yii::t('user', 'User has been blocked')];
                }
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
            }
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);

        $model->confirm();

        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been confirmed'));

        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionAssignments($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        return $this->render('_assignments', [
            'user' => $user
        ]);
    }
}