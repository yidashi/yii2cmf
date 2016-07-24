<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午2:12
 */

namespace common\actions;

use common\models\Tag;
use yii\base\Action;

class TagSearchAction extends Action
{
    /**
     * @var bool
     */
    public $skipEmpty = false;

    public function run()
    {
        \Yii::$app->response->format = 'json';
        $q = \Yii::$app->request->get('q');

        if (empty($q) && $this->skipEmpty) {
            $data = ['id' => '', 'text' => ''];
        } else {
            $data = Tag::find()->where(['like', 'name', $q])->select('name id,name text')->asArray()->all();
        }
        return [
            'results' => $data
        ];
    }
}