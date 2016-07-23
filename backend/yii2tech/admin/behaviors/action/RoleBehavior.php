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
use yii\widgets\ActiveForm;
use yii2tech\admin\ActionEvent;

/**
 * RoleBehavior provides common functionality for the actions, which handle models with [[\yii2tech\ar\role\RoleBehavior]] attached.
 * This behavior should be attached to [[\yii2tech\admin\actions\Action]] instance.
 * This behavior relies on events triggered by [[\yii2tech\admin\actions\ModelFormTrait]].
 *
 * @see https://github.com/yii2tech/ar-role
 * @see \yii2tech\admin\actions\ModelFormTrait
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class RoleBehavior extends Behavior
{
    /**
     * @var array list of model role behavior names, which should be affected by the action.
     * If empty - all instances of [[RoleBehavior]] will be picked up.
     */
    public $roleNames = [];

    /**
     * @var array cache for the role models.
     */
    private $_roleModels = [];


    /**
     * Get role models for the main one.
     * @param Model|ActiveRecordInterface $model main model instance.
     * @return Model[] list of role models
     */
    public function getRoleModels($model)
    {
        $key = serialize($model->getPrimaryKey());
        if (!isset($this->_roleModels[$key])) {
            $this->_roleModels[$key] = $this->findRoleModels($model);
        }
        return $this->_roleModels[$key];
    }

    /**
     * @param Model|ActiveRecordInterface $model
     * @return array list of variation models in format: behaviorName => Model[]
     */
    private function findRoleModels($model)
    {
        $roleModels = [];
        foreach ($model->getBehaviors() as $name => $behavior) {
            if ((empty($this->roleNames) && ($behavior instanceof \yii2tech\ar\role\RoleBehavior)) || in_array($name, $this->roleNames)) {
                $roleModels[$name] = $behavior->getRoleRelationModel();
            }
        }
        return $roleModels;
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
     * Populates the role models with input data.
     * @param ActionEvent $event event instance.
     */
    public function afterDataLoad($event)
    {
        if (!$event->result) {
            return;
        }

        $model = $event->model;
        $data = Yii::$app->request->post();

        foreach ($this->getRoleModels($model) as $roleModel) {
            if (!$roleModel->load($data)) {
                return;
            }
        }
    }

    /**
     * Performs AJAX validation of the role models via [[ActiveForm::validate()]].
     * @param ActionEvent $event event instance.
     */
    public function afterAjaxValidate($event)
    {
        $model = $event->model;

        $roleModels = $this->getRoleModels($model);

        $event->result = array_merge(
            $event->result,
            call_user_func_array([ActiveForm::className(), 'validate'], $roleModels)
        );
    }
}