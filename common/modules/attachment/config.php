<?php
return [
    [
        'name' => 'filesystem_type',
        'type' => 'radio',
        'value' => 'local',
        'desc' => '文件系统',
        'extra' => [
            'local' => '本地',
            'qiniu' => '七牛',
//            'aliyuncs' => '阿里云oss',
        ]
    ],
    [
        'name' => 'qiniu_access_key',
        'type' => 'text',
        'value' => '',
        'desc' => '七牛access_key',
    ],
    [
        'name' => 'qiniu_access_secret',
        'type' => 'text',
        'value' => '',
        'desc' => '七牛access_secret',
    ],
    [
        'name' => 'qiniu_bucket',
        'type' => 'text',
        'value' => '',
        'desc' => '七牛bucket',
    ],
    [
        'name' => 'qiniu_domain',
        'type' => 'text',
        'value' => '',
        'desc' => '七牛域名',
    ],
];