<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\web\Response;

/**
 * Create action supports creation of the new model using web form.
 *
 * @see ModelFormTrait
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Create extends Action
{
    use ModelFormTrait;

    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'create';
    /**
     * @var callable a PHP callable that will be called to create the new model.
     * If not set, [[newModel()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the new model instance.
     */
    public $newModel;
    /**
     * @var boolean|callable provides control for model default values populating.
     * If set to `false` - no default value population will be performed.
     * If set to `true` - it will invoke `loadDefaultValues()` method on model.
     * You can set this as a callable of following signature:
     *
     * ```php
     * function ($model) {
     *     // populate default values.
     * }
     * ```
     */
    public $loadDefaultValues = false;


    /**
     * Creates new model instance.
     * @return ActiveRecordInterface|Model new model instance.
     * @throws InvalidConfigException on invalid configuration.
     */
    public function newModel()
    {
        if ($this->newModel !== null) {
            return call_user_func($this->newModel, $this);
        } elseif ($this->controller->hasMethod('newModel')) {
            return call_user_func([$this->controller, 'newModel'], $this);
        } else {
            throw new InvalidConfigException('Either "' . get_class($this) . '::newModel" must be set or controller must declare method "newModel()".');
        }
    }

    /**
     * Creates new record.
     * @return mixed response
     */
    public function run()
    {
        $model = $this->newModel();
        $model->scenario = $this->scenario;

        if ($this->load($model, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->performAjaxValidation($model);
            }
            if ($model->save()) {
                $this->setFlash($this->flash, ['model' => $model]);
                return $this->controller->redirect($this->createReturnUrl('view', $model));
            }
        } else {
            $this->loadModelDefaultValues($model);
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * Populates given model with the default values.
     * @param Model $model model to be processed.
     */
    protected function loadModelDefaultValues($model)
    {
        if ($this->loadDefaultValues === false) {
            return;
        }
        if ($this->loadDefaultValues === true) {
            $model->loadDefaultValues();
        } else {
            call_user_func($this->loadDefaultValues, $model);
        }
    }
}