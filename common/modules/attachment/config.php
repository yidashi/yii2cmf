<?php
return [
    [
        'name' => 'default_driver',
        'type' => 'radio',
        'value' => 'local',
        'desc' => '默认文件存储',
        'extra' => [
            'local' => '本地',
            'qiniu' => '七牛',
//            'aliyuncs' => '阿里云oss',
        ]
    ],
    [
        'name' => 'local_root',
        'type' => 'text',
        'value' => Yii::getAlias('@storagePath/upload'),
        'desc' => '本地文件系统根目录',
    ],
    [
        'name' => 'local_url',
        'type' => 'text',
        'value' => Yii::getAlias('@storageUrl/upload'),
        'desc' => '本地文件系统根地址',
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