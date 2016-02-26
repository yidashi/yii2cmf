<?php
/**
 * FontAwesome.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome;

use rmrevin\yii\fontawesome\component;

/**
 * Class FA
 * @package rmrevin\yii\fontawesome
 */
class FontAwesome
{

    /** @var string CSS Class prefix */
    public static $cssPrefix = 'fa';

    /**
     * Creates an `Icon` component that can be used to FontAwesome html icon
     *
     * @param string $name
     * @param array $options
     * @return component\Icon
     */
    public static function icon($name, $options = [])
    {
        return new component\Icon($name, $options);
    }

    /**
     * Shortcut for `icon()` method
     * @see icon()
     *
     * @param string $name
     * @param array $options
     * @return component\Icon
     */
    public static function i($name, $options = [])
    {
        return static::icon($name, $options);
    }

    /**
     * Creates an `Stack` component that can be used to FontAwesome html icon
     *
     * @param array $options
     * @return component\Stack
     */
    public static function stack($options = [])
    {
        return new component\Stack($options);
    }

    /**
     * Shortcut for `stack()` method
     * @see stack()
     *
     * @param array $options
     * @return component\Stack
     */
    public static function s($options = [])
    {
        return static::stack($options);
    }

    /**
     * Size values
     * @see rmrevin\yii\fontawesome\component\Icon::size
     */
    const SIZE_LARGE = 'lg';
    const SIZE_2X = '2x';
    const SIZE_3X = '3x';
    const SIZE_4X = '4x';
    const SIZE_5X = '5x';

    /**
     * Rotate values
     * @see rmrevin\yii\fontawesome\component\Icon::rotate
     */
    const ROTATE_90 = '90';
    const ROTATE_180 = '180';
    const ROTATE_270 = '270';

    /**
     * Flip values
     * @see rmrevin\yii\fontawesome\component\Icon::flip
     */
    const FLIP_HORIZONTAL = 'horizontal';
    const FLIP_VERTICAL = 'vertical';
}
