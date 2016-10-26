<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午11:28
 */

namespace common\actions;

use Yii;
use yii\base\DynamicModel;
use yii\base\Exception;

class AjaxUpdateFieldAction extends \backend\actions\Action
{
    public $allowFields = [];

    public $findModel;

    public function run()
    {
        Yii::$app->response->format = 'json';
        $pk = Yii::$app->request->post('pk');
        $id = unserialize(base64_decode($pk));
        $post = Yii::$app->request->post();
        $formModel = DynamicModel::validateData(['id' => $id, 'name' => $post['name'], 'value' => $post['value']], [
            [['id'], 'required'],
            ['name', 'in', 'range' => $this->allowFields]
        ]);
        if ($formModel->hasErrors()) {
            throw new Exception(current($formModel->getFirstErrors()));
        }
        $model = $this->findModel($id);
        $model->updateAll([$post['name'] => $post['value']], ['id' => $id]);
        return ['status' => 1];
    }
}