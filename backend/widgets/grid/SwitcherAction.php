<?php
namespace backend\widgets\grid;

use backend\actions\Action;
use Yii;

class SwitcherAction extends Action
{
    public function run()
    {
        Yii::$app->response->format = 'json';
        $id = Yii::$app->request->post('id');
        $attribute = Yii::$app->request->post('attribute');
        $value = Yii::$app->request->post('value');
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