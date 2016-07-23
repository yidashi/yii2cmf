<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\behaviors\action;

use Yii;
use yii\base\Behavior;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Html;
use yii2tech\admin\ActionEvent;

/**
 * VariationBehavior provides common functionality for the actions, which handle models with [[\yii2tech\ar\variation\VariationBehavior]] attached.
 * This behavior should be attached to [[\yii2tech\admin\actions\Action]] instance.
 * This behavior relies on events triggered by [[\yii2tech\admin\actions\ModelFormTrait]].
 *
 * @see https://github.com/yii2tech/ar-variation
 * @see \yii2tech\admin\actions\ModelFormTrait
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class VariationBehavior extends Behavior
{
    /**
     * @var array list of model variation behavior names, which should be affected by the action.
     * If empty - all instances of [[\yii2tech\ar\variation\VariationBehavior]] will be picked up.
     */
    public $variationNames = [];

    /**
     * @var array cache for the variation model batches.
     */
    private $_variationModelBatches = [];


    /**
     * Get variation models for the main one in batches.
     * @param Model|ActiveRecordInterface $model main model instance.
     * @return array list of variation models in format: behaviorName => Model[]
     */
    protected function getVariationModelBatches($model)
    {
        $key = serialize($model->getPrimaryKey());
        if (!isset($this->_variationModelBatches[$key])) {
            $this->_variationModelBatches[$key] = $this->findVariationModelBatches($model);
        }
        return $this->_variationModelBatches[$key];
    }

    /**
     * @param Model|ActiveRecordInterface $model
     * @return array list of variation models in format: behaviorName => Model[]
     */
    protected function findVariationModelBatches($model)
    {
        $variationModels = [];
        foreach ($model->getBehaviors() as $name => $behavior) {
            if ((empty($this->variationNames) && ($behavior instanceof \yii2tech\ar\variation\VariationBehavior)) || in_array($name, $this->variationNames)) {
                $variationModels[$name] = $behavior->getVariationModels();
            }
        }
        return $variationModels;
    }

    // Events :

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            'afterDataLoad' => 'afterDataLoad',
            'afterAjaxValidate' => 'afterAjaxValidate',
        ];
    }

    /**
     * Handles `afterDataLoad` event.
     * Populates the variation models with input data.
     * @param ActionEvent $event event instance.
     */
    public function afterDataLoad($event)
    {
        if (!$event->result) {
            return;
        }

        $model = $event->model;
        $data = Yii::$app->request->post();

        foreach ($this->getVariationModelBatches($model) as $variationName => $variationModels) {
            if (!Model::loadMultiple($variationModels, $data)) {
                $event->result = false;
                return;
            }
        }
    }

    /**
     * Handles `afterAjaxValidate` event.
     * Performs AJAX validation of the variation models via [[ActiveForm::validate()]].
     * @param ActionEvent $event event instance.
     */
    protected function afterAjaxValidate($event)
    {
        $model = $event->model;
        $response = $event->result;

        // validate variations manually for tabular input matching :
        foreach ($this->getVariationModelBatches($model) as $variationModels) {
            foreach ($variationModels as $index => $variationModel) {
                /* @var $variationModel Model */
                if (!$variationModel->validate()) {
                    foreach ($model->getErrors() as $attribute => $errors) {
                        $response[Html::getInputId($model, '[' . $index . ']' . $attribute)] = $errors;
                    }
                }
            }
        }

        $event->data['result'] = $response;
    }
}