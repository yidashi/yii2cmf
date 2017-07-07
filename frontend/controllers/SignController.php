<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 上午10:17
 */

namespace frontend\controllers;


use common\models\Sign;
use common\models\SignInfo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;

class SignController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['sign'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'verbs' => ['get']
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $signInfo = SignInfo::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Sign::findToday()->orderBy('sign_at asc'),
            'pagination' => [
                'defaultPageSize' => 100
            ]
        ]);
        $monthStart = strtotime(date('Y-m-1'));
        $monthEnd = strtotime("+1 month", $monthStart);
        $signDays = Sign::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['between', 'sign_at', $monthStart, $monthEnd])->select(new Expression('FROM_UNIXTIME(sign_at, "%d")'))->column();
        $daysNum = date('t');
        $year = date('Y');
        $month = date('m');
        $weeks = [];
        $i = 0;
        foreach (range(1, $daysNum) as $day) {
            $w = date('w', strtotime($year . '-' . $month . '-' . $day));
            $weeks[$i][$w]['day'] = $day;
            $weeks[$i][$w]['sign'] = in_array($day, $signDays);
            if ($w == 6) {
                $i++;
            }
        }
        return $this->render('index', [
            'signInfo' => $signInfo,
            'dataProvider' => $dataProvider,
            'weeks' => $weeks,
        ]);
    }

    public function actionSign()
    {
        Yii::$app->response->format = 'json';
        /**
         * @var Sign $sign
         * @var SignInfo $signInfo
         */
        $sign = Sign::findToday()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $signInfo = SignInfo::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        // 没签的签，签了就不管了，正常不会签了还有请求过来
        if (empty($sign)) {
            $sign = new Sign();
            $sign->user_id = Yii::$app->user->id;
            $sign->sign_at = time();
            $sign->save();
            if (empty($signInfo)) {
                $signInfo = new SignInfo();
                $signInfo->last_sign_at = $sign->sign_at;
                $signInfo->user_id = $sign->user_id;
                $signInfo->times = 1;
                $signInfo->continue_times = 1;
                $signInfo->save();
            } else {
                // 如果上次签到是昨天,连续签到
                if (date('Ymd', $signInfo->last_sign_at) == date('Ymd', time() - 60 * 60 *24)) {
                    $signInfo->continue_times += 1;
                } else {
                    $signInfo->continue_times = 1;
                }
                $signInfo->last_sign_at = time();
                $signInfo->times += 1;
                $signInfo->save();
            }

        }
        return [
            'days' => $signInfo->continue_times
        ];
    }
}