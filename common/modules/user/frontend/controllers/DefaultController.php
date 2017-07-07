<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 上午11:37
 */

namespace common\modules\user\frontend\controllers;

use common\models\Favourite;
use common\models\Sign;
use common\modules\user\models\User;
use common\models\Article;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if (empty($user)) {
            throw new NotFoundHttpException('用户不存在!');
        }

        $monthStart = strtotime(date('Y-m-1'));
        $monthEnd = strtotime("+1 month", $monthStart);
        $signDays = Sign::find()->where(['user_id' => $id])->andWhere(['between', 'sign_at', $monthStart, $monthEnd])->select(new Expression('FROM_UNIXTIME(sign_at, "%d")'))->column();
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
            'user' => $user,
            'weeks' => $weeks
        ]);
    }

    public function actionArticleList()
    {
        $query = Article::find()->my()->notTrashed();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        $pages = $dataProvider->getPagination();
        $models = $dataProvider->getModels();
        return $this->render('article/list', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionCreateArticle($module = 'base')
    {
        $model = new Article(['module' => $module]);
        $moduleClass = $model->findModuleClass();
        $moduleModel = new $moduleClass();
        if ($model->load(\Yii::$app->request->post()) && $moduleModel->load(\Yii::$app->request->post()) && $model->validate() && $moduleModel->validate() && $model->save(false)) {
            $moduleModel->id = $model->id;
            if ($moduleModel->save(false)) {
                \Yii::$app->session->setFlash('success', '发布成功！');
                return $this->redirect(['create-article']);
            }
        }

        return $this->render('article/create', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }
    public function actionUpdateArticle($id)
    {
        $model = Article::find()->where(['id' => $id])->my()->with('data')->one();
        if ($model == null) {
            throw new NotFoundHttpException('文章不存在或者不属于你');
        }
        $moduleModel = $model->data;
        if (
            $model->load(\Yii::$app->request->post())
            && $model->validate()
            && $moduleModel->load(\Yii::$app->request->post())
            && $moduleModel->validate()
            && $model->save(false)
            && $moduleModel->save(false)
        ) {
            \Yii::$app->session->setFlash('success', '修改成功！');
            return $this->redirect(['update-article', 'id' => $id]);
        }

        return $this->render('article/update', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }

    public function actionDeleteArticle($id)
    {
        $model = Article::find()->where(['id' => $id])->my()->one();
        if ($model == null) {
            throw new NotFoundHttpException('文章不存在或者不属于你');
        }
        if ($model->softDelete()) {
            \Yii::$app->session->setFlash('success', '删除成功！');
            return $this->redirect(['article-list']);
        }
    }

    public function actionFavourite()
    {
        $userId = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Favourite::find()->where(['user_id' => $userId]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('favourite/index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionNotice()
    {
        Yii::$app->notify->readAll();
        $dataProvider = Yii::$app->notify->getDataProvider();
        return $this->render('notice/index', [
            'dataProvider' => $dataProvider
        ]);
    }
}