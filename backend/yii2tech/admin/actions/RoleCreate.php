<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use yii2tech\admin\behaviors\action\RoleBehavior;

/**
 * RoleCreate action supports creation of the new model with [yii2tech/ar-role](https://github.com/yii2tech/ar-role) behavior applied.
 *
 * @see https://github.com/yii2tech/ar-role
 * @see RoleBehavior
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class RoleCreate extends Create
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => RoleBehavior::className()
            ]
        ];
    }
}