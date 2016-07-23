<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\grid;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * ActionColumn is a variation of [[\yii\grid\ActionColumn]], which allows to specify [[buttons]] as array configurations.
 * Supported button options:
 *
 * - label: string - button label.
 * - encode: boolean - whether to encode label.
 * - icon: string - button icon short name.
 * - options: array - link tag HTML options.
 * - visible: boolean|callable - whether button should be rendered or not.
 * - url: callable - callback, which should return button URL.
 *
 * This widget also provides default buttons as configuration, which will be merged with [[buttons]] recursively.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @inheritdoc
     */
    public $template = '{view} {update} {delete}{restore}';


    /**
     * Merges buttons with default configurations.
     */
    protected function initDefaultButtons()
    {
        $this->buttons = ArrayHelper::merge(
            [
                'view' => [
                    'icon' => 'eye-open',
                    'options' => [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                    ],
                ],
                'update' => [
                    'icon' => 'pencil',
                    'options' => [
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                    ],
                ],
                'delete' => [
                    'icon' => 'trash',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if (is_object($model) && $model->canGetProperty('isDeleted')) {
                            return !$model->isDeleted;
                        }
                        return true;
                    },
                    'options' => [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ],
                ],
                'restore' => [
                    'icon' => 'repeat',
                    'visible' => function ($model) {
                        /* @var $model \yii\db\BaseActiveRecord */
                        if (is_object($model) && $model->canGetProperty('isDeleted')) {
                            return $model->isDeleted;
                        }
                        return false;
                    },
                    'options' => [
                        'title' => Yii::t('yii2tech-admin', 'Restore'),
                        'aria-label' => Yii::t('yii2tech-admin', 'Restore'),
                        'data-confirm' => Yii::t('yii2tech-admin', 'Are you sure you want to restore this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
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
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            return $this->renderButton($name, $model, $key, $index);
        }, $this->template);
    }

    /**
     * Renders button.
     * @param string $name button name.
     * @param $model
     * @param $key
     * @param $index
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
     * @inheritdoc
     */
    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
            $params = $params + Yii::$app->request->getQueryParams(); // preserve numeric keys
            return Url::toRoute($params);
        }
    }
}
