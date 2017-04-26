<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/15
 * Time: 下午2:05
 */

namespace common\modules\book\controllers;


use backend\actions\Position;
use common\modules\book\models\Book;
use common\modules\book\models\BookChapter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actions()
    {
        return [
            'move-chapter' => [
                'class' => Position::className(),
                'returnUrl' => request()->referrer,
                'findModel' => function($id) {
                    return BookChapter::findOne($id);
                }
            ]
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => Book::find()]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        if ($model->load(request()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '保存成功');
            return $this->redirect('index');
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        $model = Book::findOne($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionChapter($id)
    {
        $model = BookChapter::findOne($id);
        return $this->render('chapter', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Book::findOne($id);
        if ($model->load(request()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '保存成功');
            return $this->redirect('index');
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionCreateChapter($id, $chapter_id = 0)
    {
        $model = new BookChapter();
        $model->book_id = $id;
        if ($chapter_id > 0) {
            $model->pid = $chapter_id;
        }
        if ($model->load(request()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '保存成功');
            return $this->redirect(['update-chapter', 'id' => $model->id]);
        }
        return $this->render('create-chapter', [
            'model' => $model
        ]);
    }

    public function actionUpdateChapter($id)
    {
        $model = BookChapter::findOne($id);
        if ($model->load(request()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '保存成功');
            return $this->refresh();
        }
        return $this->render('update-chapter', [
            'model' => $model
        ]);
    }

    public function actionDeleteChapter($id)
    {
        $model = BookChapter::findOne($id);
        $model->delete();
        return $this->redirect('index');
    }
}