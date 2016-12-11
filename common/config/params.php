<?php
return [
    'user.passwordResetTokenExpire' => 3600,
    'webuploader_driver' => env('WEBUPLOADER_DRIVER', 'local'),
    'webuploader_qiniu_config' => [
        'domain' => env('WEBUPLOADER_QINIU_DOMAIN'),
        'bucket' => env('WEBUPLOADER_QINIU_BUCKET'),
        'accessKey' => env('WEBUPLOADER_QINIU_ACCESS'),
        'secretKey' => env('WEBUPLOADER_QINIU_SECRET'),
    ]
];
