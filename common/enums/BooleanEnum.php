<?php

namespace common\enums;

class BooleanEnum
{
    const TRUE = 1;
    const FLASE = 0;

    public static $list = [
        self::TRUE => '是',
        self::FLASE => '否'
    ];
}