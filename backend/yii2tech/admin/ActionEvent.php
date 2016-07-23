<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin;

/**
 * ActionEvent represents the event triggered by admin action.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class ActionEvent extends \yii\base\ActionEvent
{
    /**
     * @var \yii\base\Model|null associated model instance.
     */
    public $model;
}