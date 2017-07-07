<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午9:57
 */

namespace frontend\components;


use common\models\Article;
use common\models\Search as SearchModel;
use yii\base\Component;
use yii\data\ActiveDataProvider;

class Search extends Component
{
    public $engine = 'local';


    public function search($q)
    {
        return call_user_func([$this, $this->engine], $q);
    }
    public function xunsearch($q)
    {
        $search = new SearchModel();
        return $search->search($q);
    }

    public function local($q)
    {
        return new ActiveDataProvider([
            'query' => Article::find()->published()->andWhere(['like', 'title', $q])
        ]);
    }
}