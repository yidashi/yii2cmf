<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/16
 * Time: 上午11:24
 */
$b = 1;

function hehe () {
    global $b;
    $b = ++$b + ++$b;
    echo $b;
}
hehe();