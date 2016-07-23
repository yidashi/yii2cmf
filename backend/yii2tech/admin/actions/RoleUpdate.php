<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use yii2tech\admin\behaviors\action\RoleBehavior;

/**
 * RoleUpdate action supports updating of the existing model with [yii2tech/ar-role](https://github.com/yii2tech/ar-role) behavior applied.
 *
 * @see https://github.com/yii2tech/ar-role
 * @see RoleBehavior
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class RoleUpdate extends Update
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