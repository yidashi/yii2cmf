<?php
namespace backend\widgets\grid;

use Yii;
use yii2tech\admin\actions\Action;

class SwitcherAction extends Action
{
    public function run($id, $attribute,$value)
    {
        Yii::$app->response->format = 'json';
        $model = $this->findModel($id);
        $model->setAttribute($attribute,intval($value));
        $model->update();

        if(count($model->errors) >0)
        {
            $error = current($model->getFirstErrors());
            return [
                'status' => false,
                'msg' => $error
            ];
        } else {
            return [
                'status' => true,
                'msg' => '更新成功'
            ];
        }
    }

}