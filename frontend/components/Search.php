<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午9:57
 */

namespace frontend\components;


use common\models\Article;
use yii\base\Component;
use common\models\Search as SearchModel;
use yii\data\ActiveDataProvider;

class Search extends Component
{
    public function search($q)
    {
        $search = new SearchModel();
        return $search->search($q);
    }

    /**
     * 如果不用迅搜,则替换这个方法
     */
    /*public function search($q)
    {
        return new ActiveDataProvider([
            'query' => Article::find()->published()->andWhere(['like', 'title', $q])
        ]);
    }*/
}