<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午10:41
 */

namespace common\modules\user\frontend\controllers;


use common\modules\attachment\models\Attachment;
use common\modules\user\models\Auth;
use common\modules\user\models\Profile;
use common\modules\user\models\Token;
use common\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'accessControl' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionBasic()
    {
        return $this->render('basic', [
            'model' => Yii::$app->user->identity
        ]);
    }

    public function actionProfile()
    {
        $userId = \Yii::$app->user->id;
        $profile = Profile::find()->where(['user_id' => $userId])->one();
        if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile', [
                'model' => $profile
            ]);
        }
    }
    public function actionAvatar()
    {
        $user = \Yii::$app->user->identity;

        if (Yii::$app->getRequest()->isAjax) {
            $avatar = Yii::$app->getRequest()->post("avatar");
            $x = Yii::$app->getRequest()->post("x");
            $y = Yii::$app->getRequest()->post("y");
            $w = Yii::$app->getRequest()->post("w");
            $h = Yii::$app->getRequest()->post("h");

            $cropUrl = Yii::$app->storage->crop($avatar, $w, $h, [$x, $y]);
            //再传一次裁剪后的图片
            list($cropAttachment, $error) = Attachment::uploadFromUrl('avatar/' . $user->id, $cropUrl);
            if ($error == null) {
                $user->saveAvatar($cropAttachment->url);

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $result = [
                    'status' => true,
                    'msg' => '保存成功'
                ];
            } else {
                $result = [
                    'status' => false,
                    'msg' => $error
                ];
            }

            return $result;
        }

        return $this->render('avatar', [
            'user' => $user
        ]);
    }

    public function actionAuth()
    {
        return $this->render('auth');
    }

    public function actionDisconnect($id)
    {
        $auth = Auth::find()->where(['user_id' => Yii::$app->user->id, 'source' => $id])->one();
        if ($auth === null) {
            throw new NotFoundHttpException();
        }
        $auth->delete();
        return $this->redirect(['auth']);
    }

    public function actionSendConfirm()
    {
        Yii::$app->response->format = 'json';
        $email = Yii::$app->request->post('email');
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        list($result, $msg) = $user->sendConfirm($email);
        if ($result) {
            return [
                'status' => 1,
                'msg' => \Yii::t(
                    'user',
                    'A message has been sent to your email address. It contains a confirmation link that you must click to complete registration.'
                )
            ];
        } else {
            return [
                'status' => 0,
                'msg' => $msg
            ];
        }
    }
}