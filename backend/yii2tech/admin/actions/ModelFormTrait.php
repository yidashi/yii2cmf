<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use yii\base\Model;
use yii\widgets\ActiveForm;
use yii2tech\admin\ActionEvent;

/**
 * ModelFormTrait provides basic functionality for the actions, which handles model input collection from web form.
 * This trait should be used inside the descendant of [[Action]] class.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
trait ModelFormTrait
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string|array|null flash message to be set on success.
     * @see Action::setFlash() for details on how setup flash.
     */
    public $flash;


    /**
     * Populates the model with input data.
     * @param Model $model model instance.
     * @param array $data the data array to load, typically `$_POST` or `$_GET`.
     * @return boolean whether expected forms are found in `$data`.
     */
    protected function load($model, $data)
    {
        /* @var $this Action */
        $event = new ActionEvent($this, [
            'model' => $model,
            'result' => $model->load($data),
        ]);
        $this->trigger('afterDataLoad', $event);

        return $event->result;
    }

    /**
     * Performs AJAX validation of the model via [[ActiveForm::validate()]].
     * @param Model $model main model.
     * @return array the error message array indexed by the attribute IDs.
     */
    protected function performAjaxValidation($model)
    {
        /* @var $this Action */
        $event = new ActionEvent($this, [
            'model' => $model,
            'result' => ActiveForm::validate($model),
        ]);

        $this->trigger('afterAjaxValidate', $event);

        return $event->result;
    }
}