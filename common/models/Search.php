<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午8:13
 */

namespace common\models;


use hightman\xunsearch\ActiveRecord;
use yii\data\ActiveDataProvider;

class Search extends ActiveRecord
{
    public function getArticle()
    {
        return Article::findOne($this->id);
    }
    public function getTrueView()
    {
        return $this->getArticle() ? $this->getArticle()->getTrueView() : 0;
    }
    public function getComment()
    {
        return $this->getArticle() ? $this->getArticle()->comment : 0;
    }
    public function search($q)
    {
        $query = self::find()->where($q)->andWhere(['status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ]
            ]
        ]);

        return $dataProvider;
    }
}