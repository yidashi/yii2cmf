<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace backend\widgets\grid;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * PositionColumn renders controls for the custom sorting position switching, provided by [yii2tech/ar-position](https://github.com/yii2tech/ar-position) extension.
 *
 * @see https://github.com/yii2tech/ar-position
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class PositionColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public $headerOptions = ['class' => 'position-column'];
    /**
     * @var string the template that is used to render the content in each cell.
     * These default tokens are recognized: {first}, {prev}, {next}, {last} and {value}.
     */
    public $template = '{first}&nbsp;{prev}&nbsp;{value}&nbsp;{next}&nbsp;{last}';
    /**
     * @var array configuration for the switch position buttons.
     */
    public $buttons = [];
    /**
     * @var array html options to be applied to the [[initDefaultButtons()|default buttons]].
     */
    public $buttonOptions = ["class"=>"btn btn-default btn-xs"];
    /**
     * @var string route to the action, which should process position switching, for example: 'item/position'.
     */
    public $route = 'position';
    /**
     * @var string name of the query param, which is used for new position specification.
     */
    public $positionParam = 'at';
    /**
     * @var callable a callback that creates a button URL using the specified model information.
     * The signature of the callback should be the same as that of [[createUrl()]].
     * If this property is not set, button URLs will be created using [[createUrl()]].
     */
    public $urlCreator;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    /**
     * Initializes the default buttons.
     */
    protected function initDefaultButtons()
    {
        $this->buttons = ArrayHelper::merge(
            [
                'first' => [
                    'icon' => 'triangle-top',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if ($this->attribute !== null && isset($model[$this->attribute])) {
                            return $model[$this->attribute] > 1;
                        }
                        return true;
                    },
                    'options' => [
                        'title' => 'Move top',
                        'aria-label' => 'Move top',
                        'data-method' => 'post'
                    ],
                ],
                'last' => [
                    'icon' => 'triangle-bottom',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if ($this->attribute !== null && isset($model[$this->attribute])) {
                            return $model[$this->attribute] < $this->grid->dataProvider->getTotalCount();
                        }
                        return true;
                    },
                    'options' => [
                        'title' => 'Move bottom',
                        'aria-label' => 'Move bottom',
                        'data-method' => 'post'
                    ],
                ],
                'prev' => [
                    'icon' => 'arrow-up',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if ($this->attribute !== null && isset($model[$this->attribute])) {
                            return $model[$this->attribute] > 1;
                        }
                        return true;
                    },
                    'options' => [
                        'title' => 'Move up',
                        'aria-label' => 'Move up',
                        'data-method' => 'post'
                    ],
                ],
                'next' => [
                    'icon' => 'arrow-down',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if ($this->attribute !== null && isset($model[$this->attribute])) {
                            return $model[$this->attribute] < $this->grid->dataProvider->getTotalCount();
                        }
                        return true;
                    },
                    'options' => [
                        'title' => 'Move down',
                        'aria-label' => 'Move down',
                        'data-method' => 'post'
                    ],
                ],
            ],
            $this->buttons
        );
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null) {
            return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
                $name = $matches[1];
                if ($name === 'value') {
                    return $this->grid->formatter->format($this->getDataCellValue($model, $key, $index), $this->format);
                }
                return $this->renderButton($name, $model, $key, $index);
            }, $this->template);
        } else {
            return parent::renderDataCellContent($model, $key, $index);
        }
    }

    /**
     * Renders button.
     * @param string $name button name.
     * @param mixed $model
     * @param string $key
     * @param integer $index
     * @return string rendered HTML
     * @throws InvalidConfigException on invalid button format.
     */
    protected function renderButton($name, $model, $key, $index)
    {
        if (!isset($this->buttons[$name])) {
            return '';
        }
        $button = $this->buttons[$name];

        if ($button instanceof \Closure) {
            $url = $this->createUrl($name, $model, $key, $index);
            return call_user_func($button, $url, $model, $key);
        }
        if (!is_array($button)) {
            throw new InvalidConfigException("Button should be either a Closure or array configuration.");
        }

        // Visibility :
        if (isset($button['visible'])) {
            if ($button['visible'] instanceof \Closure) {
                if (!call_user_func($button['visible'], $model, $key, $index)) {
                    return '';
                }
            } elseif (!$button['visible']) {
                return '';
            }
        }

        // URL :
        if (isset($button['url'])) {
            $url = call_user_func($button['url'], $name, $model, $key, $index);
        } else {
            $url = $this->createUrl($name, $model, $key, $index);
        }

        // label :
        if (isset($button['label'])) {
            $label = $button['label'];

            if (isset($button['encode'])) {
                $encodeLabel = $button['encode'];
                unset($button['encode']);
            } else {
                $encodeLabel = true;
            }
            if ($encodeLabel) {
                $label = Html::encode($label);
            }
        } else {
            $label = '';
        }

        // icon :
        if (isset($button['icon'])) {
            $icon = $button['icon'];
            $label = Html::icon($icon) . (empty($label) ? '' : ' ' . $label);
        }

        $options = array_merge(ArrayHelper::getValue($button, 'options', []), $this->buttonOptions);

        return Html::a($label, $url, $options);
    }

    /**
     * Creates a URL for the given position and model.
     * This method is called for each button and each row.
     * @param string $position the position name
     * @param \yii\db\BaseActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the current row index
     * @return string the created URL
     */
    public function createUrl($position, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $position, $model, $key, $index);
        } else {
            $params = array_merge(
                Yii::$app->getRequest()->getQueryParams(),
                is_array($key) ? $key : ['id' => (string) $key]
            );
            $params[$this->positionParam] = $position;
            $params[0] = $this->route;

            return Url::toRoute($params);
        }
    }
}