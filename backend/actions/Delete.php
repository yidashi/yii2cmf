<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/11/14
 * Time: 下午10:32
 */

namespace backend\actions;


class Delete extends Action
{
    public function run($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('success', '操作成功');
        return \Yii::$app->controller->redirect(\Yii::$app->request->getReferrer());
    }
}