<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\widgets;

use Yii;
use yii\bootstrap\Html;
use yii\base\Widget;

/**
 * ButtonContextMenu simplifies rendering of the context links such as 'update', 'view', 'delete' etc.
 * This widget renders the menu items as a link buttons.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package yii2tech\admin\widgets
 */
class ButtonContextMenu extends Widget
{
    /**
     * @var array[] list of items. Each array element represents a single menu item, which should be an array.
     * Item array should have the following structure:
     *
     * - url: array, required, the item's URL.
     * - label: string, optional, the item label.
     * - encode: boolean, optional, whether to encode item label.
     * - icon: string, optional, item label icon short name.
     *
     * Any additional keys will be used as link tag options.
     *
     * If item array contains zero key, it will be taken as 'url' key.
     */
    public $items = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = true;


    /**
     * @inheritdoc
     */
    public function run()
    {
        $contentParts = [];
        foreach ($this->items as $item) {
            $contentParts[] = $this->renderItem($item);
        }
        return implode("\n", $contentParts);
    }

    /**
     * Renders single item.
     * @param array $item item configuration.
     * @return string rendered HTML
     */
    protected function renderItem($item)
    {
        if (isset($item[0])) {
            $url = $item;
            $options = [];
        } else {
            $url = $item['url'];
            $options = $item;
            unset($options['url']);
        }

        // label :
        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            $label = $this->detectLabel($url);
        }
        if (isset($options['encode'])) {
            $encodeLabel = $options['encode'];
            unset($options['encode']);
        } else {
            $encodeLabel = $this->encodeLabels;
        }
        if ($encodeLabel) {
            $label = Html::encode($label);
        }

        // icon :
        if (isset($options['icon'])) {
            $icon = $options['icon'];
            unset($options['icon']);
        } else {
            $icon = $this->detectIcon($url);
        }
        if ($icon) {
            $label = Html::icon($icon) . ' ' . $label;
        }

        // CSS class :
        if (isset($options['class'])) {
            Html::addCssClass($options, ['widget' => 'btn']);
        } else {
            $options['class'] = [
                'btn',
                $this->detectClass($url)
            ];
        }

        if (!isset($options['data'])) {
            $options['data'] = $this->detectData($url);
        }

        return Html::a($label, $url, $options);
    }

    /**
     * @param array $url URL config.
     * @return string label
     */
    protected function detectLabel($url)
    {
        switch ($url[0]) {
            case 'index':
                return Yii::t('yii2tech-admin', 'Back');
            case 'create':
                return Yii::t('yii2tech-admin', 'Create');
            case 'update':
                return Yii::t('yii2tech-admin', 'Update');
            case 'delete':
                return Yii::t('yii2tech-admin', 'Delete');
            case 'view':
                return Yii::t('yii2tech-admin', 'View');
            case 'default':
                return Yii::t('yii2tech-admin', 'Restore Defaults');
            case 'import':
                return Yii::t('yii2tech-admin', 'Import');
            default:
                return ucfirst($url[0]);
        }
    }

    /**
     * @param array $url URL config
     * @return boolean|string icon short name, 'false' on failure
     */
    protected function detectIcon($url)
    {
        switch ($url[0]) {
            case 'index':
                return 'arrow-left';
            case 'create':
                return 'plus';
            case 'update':
                return 'pencil';
            case 'delete':
                return 'trash';
            case 'view':
                return 'eye-open';
            case 'default':
                return 'btn-repeat';
            case 'import':
                return 'import';
            default:
                return false;
        }
    }

    /**
     * @param array $url URL config
     * @return string CSS class.
     */
    protected function detectClass($url)
    {
        switch ($url[0]) {
            case 'index':
                return 'btn-default';
            case 'create':
                return 'btn-success';
            case 'update':
                return 'btn-primary';
            case 'delete':
                return 'btn-danger';
            case 'view':
                return 'btn-info';
            case 'default':
                return 'btn-danger';
            case 'import':
                return 'btn-success';
            default:
                return 'btn-default';
        }
    }

    /**
     * @param array $url URL config
     * @return array|null link data
     */
    protected function detectData($url)
    {
        switch ($url[0]) {
            case 'delete':
                return [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ];
            case 'restore':
                return [
                    'confirm' => Yii::t('yii2tech-admin', 'Are you sure you want to restore this item?'),
                    'method' => 'post',
                ];
            case 'default':
                return [
                    'confirm' => Yii::t('yii2tech-admin', 'Are you sure you want to restore defaults?'),
                ];
            default:
                return null;
        }
    }
}