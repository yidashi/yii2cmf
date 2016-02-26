<?php
/**
 * Stack.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome\component;

use yii\helpers\Html;

/**
 * Class Stack
 * @package rmrevin\yii\fontawesome\component
 */
class Stack
{

    /** @var string */
    public static $defaultTag = 'span';

    /** @var string */
    private $tag;

    /** @var array */
    private $options = [];

    /** @var Icon */
    private $icon_front;

    /** @var Icon */
    private $icon_back;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        Html::addCssClass($options, 'fa-stack');

        $this->options = $options;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param string|Icon $icon
     * @param array $options
     * @return self
     */
    public function icon($icon, $options = [])
    {
        if (is_string($icon)) {
            $icon = new Icon($icon, $options);
        }

        $this->icon_front = $icon;

        return $this;
    }

    /**
     * @param string|Icon $icon
     * @param array $options
     * @return self
     */
    public function on($icon, $options = [])
    {
        if (is_string($icon)) {
            $icon = new Icon($icon, $options);
        }

        $this->icon_back = $icon;

        return $this;
    }

    /**
     * Change html tag.
     * @param string $tag
     * @return static
     * @throws \yii\base\InvalidParamException
     */
    public function tag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string|null $tag
     * @param array $options
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function render($tag = null, $options = [])
    {
        $tag = empty($tag) ?
            (empty($this->tag) ? static::$defaultTag : $this->tag)
            : $tag;

        $options = array_merge($this->options, $options);

        $icon_back = $this->icon_back instanceof Icon
            ? $this->icon_back->addCssClass('fa-stack-2x')
            : null;

        $icon_front = $this->icon_front instanceof Icon
            ? $this->icon_front->addCssClass('fa-stack-1x')
            : null;

        return Html::tag(
            $tag,
            $icon_back . $icon_front,
            $options
        );
    }
}