<?php

namespace frontend\controllers;

use common\models\Document;
use yii\data\ActiveDataProvider;

class ExhibitionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Document::find()->normal()->andWhere(['module' => 'exhibition'])->innerJoinWith('sameCityExhibition');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

}
