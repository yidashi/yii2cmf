<?php
namespace backend\widgets\grid;

use Yii;
use Closure;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ActionColumn extends  \yii\grid\ActionColumn
{
    public $buttonOptions = ["class"=>"btn btn-default btn-xs"];
    public $template = '{view} {update} {delete}';


    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {

        parent::initDefaultButtons();

        if (!isset($this->buttons['create'])) {
            $this->buttons['create'] = function ($url) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('backend', 'Create'),
                    'aria-label' => Yii::t('backend', 'Create'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);

                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['up'])) {
            $this->buttons['up'] = function ($url) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('backend', 'Up'),
                    'aria-label' => Yii::t('backend', 'Up'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);

                return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['down'])) {
            $this->buttons['down'] = function ($url) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('backend', 'Down'),
                    'aria-label' => Yii::t('backend', 'Down'),
                    'data-pjax' => '0'
                ], $this->buttonOptions);

                return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, $options);
            };
        }

    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the current row index
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index)
    {
        $url = null;

        if ($this->urlCreator instanceof Closure) {
            $url =  call_user_func($this->urlCreator, $action, $model, $key, $index,$this);
        }
        if($url !=null)
        {
            return $url;
        }

        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

        return Url::toRoute($params);
    }


}
