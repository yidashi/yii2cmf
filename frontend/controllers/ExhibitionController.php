<?php

namespace frontend\controllers;

use frontend\models\Article;
use yii\data\ActiveDataProvider;

class ExhibitionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Article::find()->normal()->andWhere(['module' => 'exhibition'])->innerJoinWith('sameCityExhibition');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

}
