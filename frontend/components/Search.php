<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午9:57
 */

namespace frontend\components;


use common\modules\document\models\Document;
use common\models\Search as SearchModel;
use yii\base\Component;
use yii\data\ActiveDataProvider;

class Search extends Component
{
    public $engine = 'db';


    public function search($q)
    {
        return call_user_func([$this, $this->engine], $q);
    }

    public function db($q)
    {
        return new ActiveDataProvider([
            'query' => Document::find()->published()->andWhere(['like', 'title', $q])
        ]);
    }
}