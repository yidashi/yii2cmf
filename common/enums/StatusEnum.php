<?php

namespace common\enums;

class StatusEnum
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;


    public static $list = [
        self::STATUS_ON => '开启',
        self::STATUS_OFF => '关闭',
    ];
}