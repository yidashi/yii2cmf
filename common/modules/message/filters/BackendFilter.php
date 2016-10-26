<?php


namespace common\modules\message\filters;

use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

class BackendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['default'];

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->id, $this->controllers)) {
            throw new NotFoundHttpException('Not found');
        }

        return true;
    }
}
