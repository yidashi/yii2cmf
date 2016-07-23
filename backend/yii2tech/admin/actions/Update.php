<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;
use yii\web\Response;

/**
 * Update action supports updating of the existing model using web form.
 *
 * @see ModelFormTrait
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Update extends Action
{
    use ModelFormTrait;

    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'update';


    /**
     * Updates existing record specified by id.
     * @param mixed $id id of the model to be deleted.
     * @return mixed response.
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $this->scenario;

        if ($this->load($model, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->performAjaxValidation($model);
            }
            if ($model->save()) {
                $this->setFlash($this->flash, ['id' => $id, 'model' => $model]);
                return $this->controller->redirect($this->createReturnUrl('view', $model));
            }
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}