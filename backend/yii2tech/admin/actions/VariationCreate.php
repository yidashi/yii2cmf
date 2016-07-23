<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use yii2tech\admin\behaviors\action\VariationBehavior;

/**
 * VariationCreate action supports creation of the new model with [yii2tech/ar-variation](https://github.com/yii2tech/ar-variation) behavior applied.
 *
 * @see https://github.com/yii2tech/ar-variation
 * @see VariationBehavior
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class VariationCreate extends Create
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => VariationBehavior::className()
            ]
        ];
    }
}