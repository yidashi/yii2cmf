<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/19
 * Time: 上午11:08
 */

namespace common\components;


use yii\base\Object;

class Queue extends Object
{
    /**
     * @param string $queue 队列分类名
     * @param string $className 处理队列的类名
     * @param array $args 参数关联数组
     */
    public function push($queue, $className, $args)
    {
        \Resque::enqueue($queue, $className, $args);
    }

    public function pop()
    {

    }
}